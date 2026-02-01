
<?php

namespace App\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use DateTime;


class Relatorios extends Component
{
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
        // DEBUG: Marcar visualmente que o método foi chamado
        $this->mensagemFiltro = '[DEBUG] Método filtrarDespesasPorData chamado em ' . now();
        $this->validate([
            'data_inicio_grafico' => 'required|date',
            'data_fim_grafico' => 'required|date',
        ]);
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
        $this->naturezaLabels = is_array($labels) ? array_values($labels) : [];
        $this->naturezaValores = is_array($valores) ? array_values($valores) : [];
        if (empty($this->naturezaLabels) || empty($this->naturezaValores)) {
            $this->mensagemFiltro = 'Sem dados para o período selecionado.';
        } else {
            $this->mensagemFiltro = '';
        }
        // Dispara evento para o frontend (Livewire >=3.x)
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
        $this->mesFiltro = now()->month;
        $this->anoFiltro = now()->year;
        $this->carregarResumo();
    }

    public function carregarResumo()
    {
        Log::info('Início carregarResumo');
        $this->despesas = DB::table('movimentos')->orderBy('id')->get();
        $this->faturas = DB::table('facturas')
            ->select('*',
                DB::raw("COALESCE(status, 'pendente') as status"),
                DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
            )
            ->orderByDesc('created_at')
            ->get();
        // Buscar apenas dívidas (pendentes e parciais)
        $this->dividas = DB::table('facturas')
            ->select('*',
                DB::raw("COALESCE(status, 'pendente') as status"),
                DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
            )
            ->whereIn(DB::raw("LOWER(COALESCE(status, 'pendente'))"), ['pendente', 'parcial'])
            ->orderByDesc('created_at')
            ->get();
        // Calcular total das dívidas
        $this->totalDividas = $this->dividas->sum(function($f) {
            return (float)($f->valor_pendente ?? 0);
        });

        // Preparar dados para gráfico de dívidas por natureza
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
        $naturezas = DB::table('movimentos')
            ->select('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro) as data_cadastro'), DB::raw('SUM(valor) as total'))
            ->groupBy('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro)'))
            ->orderBy('natureza_pagamento')
            ->get();
        $this->naturezaLabels = $naturezas->map(function($item) {
            return ($item->descricao ?? '') . ' - ' . ($item->natureza_pagamento ?? '') . ' - ' . ($item->data_cadastro ?? '');
        })->toArray();
        $this->naturezaValores = $naturezas->pluck('total')->toArray();

        // Gráfico de despesas por dia do mês filtrado
        $mes = $this->mesFiltro ?? now()->month;
        $ano = $this->anoFiltro ?? now()->year;
        $inicioMes = date('Y-m-01 00:00:00', strtotime($ano.'-'.$mes.'-01'));
        $fimMes = date('Y-m-t 23:59:59', strtotime($ano.'-'.$mes.'-01'));
        $movimentosMes = DB::table('movimentos')
            ->whereBetween('data_cadastro', [$inicioMes, $fimMes])
            ->select(DB::raw('DATE(data_cadastro) as dia'), DB::raw('SUM(valor) as total'))
            ->groupBy(DB::raw('DATE(data_cadastro)'))
            ->orderBy(DB::raw('DATE(data_cadastro)'))
            ->get();
        $this->mesCorrenteLabels = $movimentosMes->map(function($item) {
            return $item->dia;
        })->toArray();
        $this->mesCorrenteValores = $movimentosMes->pluck('total')->toArray();
        Log::info('Fim carregarResumo');
    }

    public function filtrarGraficoMesCorrente()
    {
        $this->carregarResumo();
    }

    public function filtrarPorData()
    {
        $this->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
        ]);
        $this->faturas = DB::table('facturas')
            ->select('*', DB::raw(
                "CASE WHEN status = 'reprovada' THEN 'rejeitada' ELSE COALESCE(status, 'pendente') END as status"
            ))
            ->whereBetween('created_at', [$this->data_inicio, $this->data_fim])
            ->orderByDesc('created_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.relatorios', [
            'faturas' => $this->faturas,
            'despesas' => $this->despesas,
            'dividas' => $this->dividas,
            'totalDividas' => $this->totalDividas,
            'filtro' => $this->filtro,
            'naturezaLabels' => $this->naturezaLabels,
            'naturezaValores' => $this->naturezaValores,
            'dividasNaturezaLabels' => $this->dividasNaturezaLabels,
            'dividasNaturezaValores' => $this->dividasNaturezaValores,
            'mensagemFiltro' => $this->mensagemFiltro
        ])->with(['mensagemFiltro' => $this->mensagemFiltro]);
    }
}
