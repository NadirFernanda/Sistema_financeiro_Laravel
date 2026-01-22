<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    // Listar faturas disponíveis (pendentes ou parciais)
    public function faturasDisponiveis()
    {
        $faturas = DB::table('facturas')
            ->whereIn('status', ['pendente', 'parcial'])
            ->orderBy('id')
            ->get();
        return response()->json(['faturas' => $faturas]);
    }

    // Listar todas as despesas com dados da fatura associada
    public function index()
    {
        $movimentos = DB::table('movimentos as m')
            ->leftJoin('facturas as f', 'm.fatura_id', '=', 'f.id')
            ->select('m.*',
                'f.descricao as fatura_descricao',
                'f.valor as fatura_valor',
                'f.status as fatura_status',
                'f.arquivo as fatura_arquivo',
                'm.created_at as data_cadastro')
            ->orderBy('m.id')
            ->get();
        return response()->json($movimentos);
    }
}
