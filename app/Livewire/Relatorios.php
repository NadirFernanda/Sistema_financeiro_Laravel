<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use DateTime;

class Relatorios extends Component
{
    // Gráfico de dívidas por natureza
    public $dividasNaturezaLabels = [];
    public $dividasNaturezaValores = [];
    public $mensagemFiltro = '';
    public $naturezaLabels = [];
    public $naturezaValores = [];
    // Gráfico de despesas do mês corrente
    public $mesCorrenteLabels = [];
    public $mesCorrenteValores = [];
    public $data_inicio_grafico;
    public $data_fim_grafico;
    public $mesFiltro;
    public $anoFiltro;
    public $filtro = 'todos';
    public $faturas = [];
    public $despesas = [];
    public $dividas = [];
    public $totalDividas = 0;
    public $modalAdicionarUsuario = false;

    // ========================= EXPORTAÇÃO EXCEL =========================

    public function exportarExcelDividas()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $headers = [
            'Número', 'Empresa', 'Tipo Serviço', 'Natureza', 'Tipologia',
            'Data Execução', 'Data Pagamento', 'Valor Total', 'Valor Pago',
            'Valor Pendente', 'Observações', 'Arquivo', 'Status', 'Criado em', 'Atualizado em'
        ];
        $sheet->fromArray($headers, null, 'A1');

        $row = 2;
        $dividas = $this->dividas ?? [];
        $dividas = $dividas instanceof \Illuminate\Support\Collection ? $dividas->toArray() : $dividas;

        foreach ($dividas as $d) {
            $d = (object)$d;
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

        $writer = new Xlsx($spreadsheet);
        $temp_file = tempnam(sys_get_temp_dir(), 'dividas_');

        try {
            $writer->save($temp_file);
        } catch (\Exception $e) {
            Log::error('Erro ao gerar Excel de dívidas: ' . $e->getMessage());
            $this->mensagemFiltro = 'Erro ao gerar arquivo Excel.';
            return;
        }

        return response()->download($temp_file, 'dividas.xlsx')->deleteFileAfterSend(true);
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
        $faturas = $this->faturas ?? [];
        $faturas = $faturas instanceof \Illuminate\Support\Collection ? $faturas->toArray() : $faturas;

        foreach ($faturas as $f) {
            $f = (object)$f;
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
        $temp_file = tempnam(sys_get_temp_dir(), 'faturas_');

        try {
            $writer->save($temp_file);
        } catch (\Exception $e) {
            Log::error('Erro ao gerar Excel de faturas: ' . $e->getMessage());
            $this->mensagemFiltro = 'Erro ao gerar arquivo Excel.';
            return;
        }

        return response()->download($temp_file, 'faturas.xlsx')->deleteFileAfterSend(true);
    }

    // ========================= FILTROS =========================

    public function filtrar($filtro)
    {
        $this->filtro = $filtro;
        $query = DB::table('facturas')
            ->select('*',
                DB::raw("COALESCE(status, 'pendente') as status"),
                DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente')
            );

        if ($filtro !== 'todos') {
            $query->whereRaw("LOWER(COALESCE(status,'pendente')) = ?", [strtolower($filtro)]);
        }

        $this->faturas = $query->orderByDesc('created_at')->get();
    }

    public function filtrarPorData()
    {
        $inicio = $this->formatarData($this->data_inicio_grafico, now()->startOfMonth()->format('Y-m-d'));
        $fim = $this->formatarData($this->data_fim_grafico, now()->endOfMonth()->format('Y-m-d'));

        if (strtotime($inicio) > strtotime($fim)) {
            $this->mensagemFiltro = 'Data de início maior que a data final.';
            return;
        }

        $this->faturas = DB::table('facturas')
            ->select('*', DB::raw("CASE WHEN status = 'reprovada' THEN 'rejeitada' ELSE COALESCE(status, 'pendente') END as status"))
            ->whereBetween('created_at', [$inicio, $fim])
            ->orderByDesc('created_at')
            ->get();
    }

    public function filtrarDespesasPorData()
    {
        $inicio = $this->formatarData($this->data_inicio_grafico, now()->startOfMonth()->format('Y-m-d'));
        $fim = $this->formatarData($this->data_fim_grafico, now()->endOfMonth()->format('Y-m-d'));

        if (strtotime($inicio) > strtotime($fim)) {
            $this->mensagemFiltro = 'Data de início maior que a data final.';
            return;
        }

        $naturezas = DB::table('movimentos')
            ->whereBetween('data_cadastro', [$inicio . ' 00:00:00', $fim . ' 23:59:59'])
            ->select('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro) as data_cadastro'), DB::raw('SUM(valor) as total'))
            ->groupBy('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro)'))
            ->orderBy('natureza_pagamento')
            ->get();

        $labels = $naturezas->map(fn($item) => ($item->descricao ?? '') . ' - ' . ($item->natureza_pagamento ?? '') . ' - ' . ($item->data_cadastro ?? ''))->toArray();
        $valores = $naturezas->pluck('total')->map(fn($v) => (float)$v)->toArray();

        $this->naturezaLabels = $labels;
        $this->naturezaValores = $valores;
        $this->mensagemFiltro = empty($valores) ? 'Sem dados para o período selecionado.' : '';

        $this->dispatch('atualizar-grafico-natureza-total', labels: $labels, valores: $valores, mensagem: $this->mensagemFiltro);
    }

    public function filtrarGraficoMesCorrente()
    {
        $this->atualizarGraficoDespesas();
    }

    // ========================= MONTAGEM E RESUMO =========================

    public function mount()
    {
        $this->data_inicio_grafico = now()->startOfMonth()->format('Y-m-d');
        $this->data_fim_grafico = now()->endOfMonth()->format('Y-m-d');
        $this->mesFiltro = (int) now()->format('m');
        $this->anoFiltro = (int) now()->format('Y');
        $this->carregarResumo();
    }

    public function carregarResumo()
    {
        Log::info('Início carregarResumo');

        $this->despesas = DB::table('movimentos')->orderBy('id')->get();
        $this->faturas = DB::table('facturas')
            ->select('*', DB::raw("COALESCE(status, 'pendente') as status"), DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente'))
            ->orderByDesc('created_at')
            ->get();

        $this->dividas = DB::table('facturas')
            ->select('*', DB::raw("COALESCE(status, 'pendente') as status"), DB::raw('(COALESCE(valor_total,0) - COALESCE(valor_pago,0)) as valor_pendente'))
            ->whereRaw("LOWER(COALESCE(status, 'pendente')) IN ('pendente','parcial')")
            ->orderByDesc('created_at')
            ->get();

        $this->totalDividas = $this->dividas->sum(fn($f) => (float)($f->valor_pendente ?? 0));

        $naturezaDividas = collect($this->dividas)
            ->groupBy(fn($item) => $item->natureza ?? 'Sem Natureza')
            ->map(fn($items, $natureza) => [
                'natureza' => $natureza,
                'valor' => collect($items)->sum(fn($i) => (float)($i->valor_pendente ?? 0))
            ])->values();

        $this->dividasNaturezaLabels = $naturezaDividas->pluck('natureza')->toArray();
        $this->dividasNaturezaValores = $naturezaDividas->pluck('valor')->toArray();

        $this->atualizarGraficoDespesas();
        Log::info('Fim carregarResumo');
    }

    // ========================= GRÁFICO DESPESAS =========================

    public function atualizarGraficoDespesas()
    {
        $mes = $this->mesFiltro ?: (int) now()->format('m');
        $ano = $this->anoFiltro ?: (int) now()->format('Y');

        $inicio = now()->setDate($ano, $mes, 1)->startOfMonth();
        $fim = (clone $inicio)->endOfMonth();

        $this->data_inicio_grafico = $inicio->format('Y-m-d');
        $this->data_fim_grafico = $fim->format('Y-m-d');

        $movimentos = DB::table('movimentos')
            ->whereBetween('data_cadastro', [
                $inicio->format('Y-m-d 00:00:00'),
                $fim->format('Y-m-d 23:59:59'),
            ])
            ->select('natureza_pagamento', DB::raw('SUM(valor) as total'))
            ->groupBy('natureza_pagamento')
            ->orderBy('natureza_pagamento')
            ->get();

        $labels = $movimentos->map(fn($m) => $m->natureza_pagamento ?? 'Sem natureza')->toArray();
        $valores = $movimentos->pluck('total')->map(fn($v) => (float) $v)->toArray();

        $this->mesCorrenteLabels = $labels;
        $this->mesCorrenteValores = $valores;
        $this->mensagemFiltro = empty($valores) ? 'Sem dados para o período selecionado.' : '';

        $this->dispatch('atualizar-grafico-mes-corrente', labels: $labels, valores: $valores, mensagem: $this->mensagemFiltro);
    }

    // ========================= AUXILIAR =========================

    private function formatarData($data, $fallback)
    {
        if (!$data) return $fallback;
        try {
            $dt = DateTime::createFromFormat('d/m/Y', $data);
            return $dt ? $dt->format('Y-m-d') : $data;
        } catch (\Exception $e) {
            return $fallback;
        }
    }
}
