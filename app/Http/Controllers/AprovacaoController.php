<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AprovacaoController extends Controller
{
    // Aprovar ou rejeitar fatura (presidência)
    public function aprovar(Request $request)
    {
        $request->validate([
            'faturaId' => 'required|integer|exists:facturas,id',
            'status' => 'required|string',
        ]);
        $factura = DB::table('facturas')->where('id', $request->faturaId)->first();
        if (!$factura) {
            return response()->json(['message' => 'Fatura não encontrada'], 404);
        }
        if ($factura->status !== 'APROVADA_PARA_AUTORIZACAO') {
            return response()->json(['message' => 'Fatura ainda não foi verificada pela contratação'], 400);
        }
        $novoStatus = $factura->status;
        if ($request->status === 'REJEITADA') {
            $novoStatus = 'DESCARTADA';
        } elseif ($request->status === 'APROVADA') {
            $novoStatus = 'APROVADA';
        }
        DB::table('facturas')->where('id', $request->faturaId)->update(['status' => $novoStatus]);
        $factura->status = $novoStatus;
        return response()->json($factura);
    }
}
