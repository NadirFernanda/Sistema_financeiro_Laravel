<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    // Relatório apenas de despesas
    public function despesas()
    {
        $despesas = DB::table('movimentos')->orderBy('id')->get();
        return response()->json(['despesas' => $despesas]);
    }

    // Relatório apenas de faturas
    public function facturas()
    {
        $faturas = DB::table('facturas')->select('*', DB::raw("COALESCE(status, 'pendente') as status"))->orderByDesc('created_at')->get();
        return response()->json(['faturas' => $faturas]);
    }
    // Relatório de dívidas (faturas pendentes ou parciais)
    public function facturasDividas()
    {
        $dividas = DB::table('facturas')
            ->whereRaw('COALESCE(valor_total,0) > COALESCE(valor_pago,0)')
            ->orderByDesc('created_at')
            ->get();
        return response()->json(['dividas' => $dividas]);
    }

    // Relatório de faturas filtrado por status
    public function facturasPorStatus(Request $request)
    {
        $request->validate(['status' => 'required|string']);
        $faturas = DB::table('facturas')
            ->where('status', $request->status)
            ->orderByDesc('created_at')
            ->get();
        return response()->json(['faturas' => $faturas]);
    }

    // Relatório de despesas por número de ordem
    public function despesasPorOrdem(Request $request)
    {
        $request->validate([
            'ordem_inicio' => 'required|integer',
            'ordem_fim' => 'required|integer',
        ]);
        $despesas = DB::table('movimentos')
            ->whereBetween('numero_ordem', [$request->ordem_inicio, $request->ordem_fim])
            ->orderBy('numero_ordem')
            ->get();
        return response()->json(['despesas' => $despesas]);
    }

    // Exportação para Excel (exemplo para faturas)
    public function exportarFaturasExcel()
    {
        // Requer Maatwebsite\Excel instalado e configurado
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\FaturasExport, 'faturas.xlsx');
    }
    // Relatório de despesas e faturas
    public function facturasDespesas()
    {
        $despesas = DB::table('movimentos')->orderBy('id')->get();
        $faturas = DB::table('facturas')->select('*', DB::raw("COALESCE(status, 'pendente') as status"))->orderByDesc('created_at')->get();
        return response()->json([
            'despesas' => $despesas,
            'faturas' => $faturas
        ]);
    }

    // Relatório de faturas por intervalo de datas
    public function facturasPorData(Request $request)
    {
        $request->validate([
            'data_inicio' => 'required|date',
            'data_fim' => 'required|date',
        ]);
        $faturas = DB::table('facturas')
            ->select('*', DB::raw(
                "CASE WHEN status = 'reprovada' THEN 'rejeitada' ELSE COALESCE(status, 'pendente') END as status"
            ))
            ->whereBetween('created_at', [$request->data_inicio, $request->data_fim])
            ->orderByDesc('created_at')
            ->get();
        return response()->json(['faturas' => $faturas]);
    }

    // Novo método: Relatório de despesas agrupadas por natureza
    public function despesasPorNatureza(Request $request)
    {
        // Agrupar e exibir por descricao, natureza_pagamento e data_cadastro
        $query = DB::table('movimentos')
            ->select('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro) as data_cadastro'), DB::raw('SUM(valor) as total'))
            ->groupBy('descricao', 'natureza_pagamento', DB::raw('DATE(data_cadastro)'));

        if ($request->has('data_inicio') && $request->has('data_fim')) {
            $query->whereBetween('data_cadastro', [$request->data_inicio, $request->data_fim]);
        }

        $result = $query->get();

        $descricoes = $result->pluck('descricao');
        $naturezas = $result->pluck('natureza_pagamento');
        $datas = $result->pluck('data_cadastro');
        $valores = $result->pluck('total');

        return response()->json([
            'descricoes' => $descricoes,
            'naturezas' => $naturezas,
            'datas' => $datas,
            'valores' => $valores
        ]);
    }
}
