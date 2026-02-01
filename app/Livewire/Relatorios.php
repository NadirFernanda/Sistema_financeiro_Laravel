<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// Removidos imports não utilizados
use DateTime;


class Relatorios extends Component
{
    // Filtros para o gráfico de despesas por período
    // ... já declaradas acima, remover duplicidade
    // Gráfico de dívidas por natureza
    public $dividasNaturezaLabels = [];
    public $dividasNaturezaValores = [];
    public $mensagemFiltro = '';
    public $naturezaLabels = [];
    public $naturezaValores = [];
    // Variáveis para o gráfico de despesas do mês corrente
    public $mesCorrenteLabels = [];
    public $mesCorrenteValores = [];
    public $data_inicio_grafico;
    public $data_fim_grafico;
    public $filtro = 'todos';
    public $faturas = [];
    public $despesas = [];
    public $dividas = [];
    public $totalDividas = 0;
    public $modalAdicionarUsuario = false;

    /**
     * Exporta as dívidas (pendentes e parciais) para Excel
     */
    public function exportarExcelDividas()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'Número', 'Empresa', 'Tipo Serviço', 'Natureza', 'Tipologia',
            'Data Execução', 'Data Pagamento', 'Valor Total', 'Valor Pago',
            'Valor Pendente', 'Observações', 'Arquivo', 'Status', 'Criado em', 'Atualizado em'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $dividas = $this->dividas;
        // Se for array aninhado, "achatar"
        if (is_array($dividas) && isset($dividas[0]) && is_array($dividas[0])) {
            $dividas = array_merge(...array_filter($dividas, 'is_array'));
        }
        foreach ($dividas as $d) {
            if (is_array($d)) {
                $d = (object)$d;
            }
            $sheet->fromArray([
                $d->numero_factura ?? '',
                $d->empresa_nome ?? '',
                $d->tipo_servico ?? '',
                $d->natureza ?? '',
                $d->tipologia ?? '',
                $d->data_execucao ?? '',
                $d->data_pagamento ?? '',
                $d->valor_total ?? '',
                $d->valor_pago ?? '',
                $d->valor_pendente ?? '',
                $d->observacoes ?? '',
                $d->arquivo ?? '',
                $d->status ?? '',
                $d->created_at ?? '',
                $d->updated_at ?? '',
            ], null, 'A' . $row);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $fileName = 'dividas.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
    // ... todos os outros métodos permanecem dentro da classe

    /**
     * Filtra as faturas pelo status recebido (ex: 'pendente', 'parcial', 'pagas', etc)
     */
    public function filtrar($filtro)
    {
        $this->filtro = $filtro;
        if ($filtro === 'todos') {
            $this->faturas = DB::table('facturas')
                ->select('*',
                    DB::raw("COALESCE(status, 'pendente') as status"),
                    DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
                )
                ->orderByDesc('created_at')
                ->get();
        } else {
            $this->faturas = DB::table('facturas')
                ->select('*',
                    DB::raw("COALESCE(status, 'pendente') as status"),
                    DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
                )
                ->where(DB::raw('LOWER(COALESCE(status,\'pendente\'))'), strtolower($filtro))
                ->orderByDesc('created_at')
                ->get();
        }
        // Atualize outros dados se necessário, como dividas, totais, etc.
    }
    public function filtrarDespesasPorData()
    {
        $this->mensagemFiltro = '[DEBUG] Método filtrarDespesasPorData chamado em ' . now();
        // Força formato Y-m-d antes de validar
        $inicio = $this->data_inicio_grafico;
        $fim = $this->data_fim_grafico;
        if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $inicio)) {
            $inicio = DateTime::createFromFormat('d/m/Y', $inicio)->format('Y-m-d');
        }
        if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $fim)) {
            $fim = DateTime::createFromFormat('d/m/Y', $fim)->format('Y-m-d');
        }
        // Validação robusta
        $this->validate([
            'data_inicio_grafico' => 'required|date_format:Y-m-d',
            'data_fim_grafico' => 'required|date_format:Y-m-d',
        ]);
        if (strtotime($inicio) > strtotime($fim)) {
            $this->mensagemFiltro = 'Data de início maior que a data final.';
            return;
        }
        $whereInicio = $inicio . ' 00:00:00';
        $whereFim = $fim . ' 23:59:59';
        $naturezas = DB::table('movimentos')
            ->whereBetween('data_cadastro', [$whereInicio, $whereFim])
            ->select('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro) as data_cadastro'), DB::raw('SUM(valor) as total'))
            ->groupBy('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro)'))
            ->orderBy('natureza_pagamento')
            ->get();
        $labels = $naturezas->map(function($item) {
            return ($item->descricao ?? '') . ' - ' . ($item->natureza_pagamento ?? '') . ' - ' . ($item->data_cadastro ?? '');
        })->toArray();
        $valores = $naturezas->pluck('total')->map(fn($v) => (float)$v)->values()->toArray();
        $this->naturezaLabels = $labels;
        $this->naturezaValores = $valores;
        if (empty($labels) || empty($valores)) {
            $this->mensagemFiltro = 'Sem dados para o período selecionado.';
        } else {
            $this->mensagemFiltro = '';
        }
        // Dispara evento para o frontend
        $this->dispatch('atualizar-grafico-natureza-total', [
            'labels' => $labels,
            'valores' => $valores,
            'mensagem' => $this->mensagemFiltro
        ]);
    }

    public function exportarExcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'ID', 'Número', 'Empresa', 'Tipo Serviço', 'Natureza', 'Tipologia',
            'Data Execução', 'Data Pagamento', 'Valor Total', 'Valor Pago',
            'Observações', 'Arquivo', 'Status', 'Criado em', 'Atualizado em'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        // Corrigir para lidar com arrays aninhados e ausência de id
        $faturas = $this->faturas;
        // Se for array aninhado, "achatar"
        if (is_array($faturas) && isset($faturas[0]) && is_array($faturas[0])) {
            $faturas = array_merge(...array_filter($faturas, 'is_array'));
        }
        foreach ($faturas as $f) {
            // Se for array, converter para objeto
            if (is_array($f)) {
                $f = (object)$f;
            }
            $sheet->fromArray([
                $f->id ?? '',
                $f->numero_factura ?? '',
                $f->empresa_nome ?? '',
                $f->tipo_servico ?? '',
                $f->natureza ?? '',
                $f->tipologia ?? '',
                $f->data_execucao ?? '',
                $f->data_pagamento ?? '',
                $f->valor_total ?? '',
                $f->valor_pago ?? '',
                $f->observacoes ?? '',
                $f->arquivo ?? '',
                $f->status ?? '',
                $f->created_at ?? '',
                $f->updated_at ?? '',
            ], null, 'A' . $row);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'faturas.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);

        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function mount()
    {
        // Inicializa datas do filtro para o mês corrente
        $this->data_inicio_grafico = now()->startOfMonth()->format('Y-m-d');
        $this->data_fim_grafico = now()->endOfMonth()->format('Y-m-d');
        $this->carregarResumo();
    }

    public function carregarResumo()
    {
        Log::info('Início carregarResumo');
        // Faturas e dívidas (sem filtro de período)
        $this->despesas = DB::table('movimentos')->orderBy('id')->get();
        $this->faturas = DB::table('facturas')
            ->select('*',
                DB::raw("COALESCE(status, 'pendente') as status"),
                DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
            )
            ->orderByDesc('created_at')
            ->get();
        $this->dividas = DB::table('facturas')
            ->select('*',
                DB::raw("COALESCE(status, 'pendente') as status"),
                DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
            )
            ->whereIn(DB::raw("LOWER(COALESCE(status, 'pendente'))"), ['pendente', 'parcial'])
            ->orderByDesc('created_at')
            ->get();
        $this->totalDividas = $this->dividas->sum(function($f) {
            return (float)($f->valor_pendente ?? 0);
        });

        // Gráfico de dívidas por natureza (sem filtro de período)
        $naturezaDividas = collect($this->dividas)
            ->groupBy(function($item) {
                return $item->natureza ?? 'Sem Natureza';
            })
            ->map(function($items, $natureza) {
                return [
                    'natureza' => $natureza,
                    'valor' => collect($items)->sum(function($i) { return (float)($i->valor_pendente ?? 0); })
                ];
            })->values();
        $this->dividasNaturezaLabels = $naturezaDividas->pluck('natureza')->toArray();
        $this->dividasNaturezaValores = $naturezaDividas->pluck('valor')->toArray();

        // Gráfico de despesas por período personalizado
        $this->atualizarGraficoDespesas();
        Log::info('Fim carregarResumo');
    }
    /**
     * Atualiza o gráfico de despesas por período personalizado
     */
    public function atualizarGraficoDespesas()
    {
        // Valida se datas foram fornecidas
        $this->validate([
            'data_inicio_grafico' => 'required|date',
            'data_fim_grafico' => 'required|date',
        ]);

        // Formata datas para Y-m-d
        $inicio = $this->data_inicio_grafico;
        $fim = $this->data_fim_grafico;

        if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $inicio)) {
            $inicio = DateTime::createFromFormat('d/m/Y', $inicio)->format('Y-m-d');
        }
        if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $fim)) {
            $fim = DateTime::createFromFormat('d/m/Y', $fim)->format('Y-m-d');
        }

        $whereInicio = $inicio . ' 00:00:00';
        $whereFim = $fim . ' 23:59:59';

        // Busca despesas do período
        $movimentos = DB::table('movimentos')
            ->whereBetween('data_cadastro', [$whereInicio, $whereFim])
            ->select(DB::raw('DATE(data_cadastro) as dia'), DB::raw('SUM(valor) as total'))
            ->groupBy(DB::raw('DATE(data_cadastro)'))
            ->orderBy(DB::raw('DATE(data_cadastro)'))
            ->get()
            ->keyBy('dia'); // chave = data para fácil lookup

        // Cria labels e valores preenchendo todos os dias do período
        $labels = [];
        $valores = [];

        $periodo = new \DatePeriod(
            new \DateTime($inicio),
            new \DateInterval('P1D'),
            (new \DateTime($fim))->modify('+1 day')
        );

        foreach ($periodo as $dia) {
            $diaFormat = $dia->format('Y-m-d');
            $labels[] = $dia->format('d/m'); // label do eixo X
            $valores[] = isset($movimentos[$diaFormat]) ? (float)$movimentos[$diaFormat]->total : 0;
        }

        $this->mesCorrenteLabels = $labels;
        $this->mesCorrenteValores = $valores;

        // Mensagem de feedback
        if (empty($valores) || array_sum($valores) == 0) {
            $this->mensagemFiltro = 'Sem dados para o período selecionado.';
        } else {
            $this->mensagemFiltro = '';
        }

        // Dispara evento para o frontend
        $this->dispatch('atualizar-grafico-mes-corrente', [
            'labels' => $labels,
            'valores' => $valores,
            'mensagem' => $this->mensagemFiltro
        ]);
    }

    public function filtrarGraficoMesCorrente()
    {
        $this->atualizarGraficoDespesas();
    }

    public function filtrarPorData()
    {
        // Padroniza datas para Y-m-d antes de validar
        $this->data_inicio_grafico = DateTime::createFromFormat('d/m/Y', $this->data_inicio_grafico)
            ? DateTime::createFromFormat('d/m/Y', $this->data_inicio_grafico)->format('Y-m-d')
            : $this->data_inicio_grafico;
        $this->data_fim_grafico = DateTime::createFromFormat('d/m/Y', $this->data_fim_grafico)
            ? DateTime::createFromFormat('d/m/Y', $this->data_fim_grafico)->format('Y-m-d')
            : $this->data_fim_grafico;
        $this->validate([
            'data_inicio_grafico' => 'required|date_format:Y-m-d',
            'data_fim_grafico' => 'required|date_format:Y-m-d',
        ]);
        $this->faturas = DB::table('facturas')
            ->select('*', DB::raw(
                "CASE WHEN status = 'reprovada' THEN 'rejeitada' ELSE COALESCE(status, 'pendente') END as status"
            ))
            ->whereBetween('created_at', [$this->data_inicio_grafico, $this->data_fim_grafico])
            ->orderByDesc('created_at')
            ->get();
    }
} // fecha a classe Relatorios

