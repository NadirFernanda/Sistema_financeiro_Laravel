<?php 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ContratacaoController extends Controller
{
    // Verificar fatura (contratação)
    public function verificar($id)
    {
        $factura = DB::table('facturas')->where('id', $id)->first();
        if (!$factura) {
            return response()->json(['message' => 'Fatura não encontrada'], 404);
        }
        DB::table('facturas')->where('id', $id)->update(['status' => 'APROVADA_PARA_AUTORIZACAO']);
        $factura->status = 'APROVADA_PARA_AUTORIZACAO';
        return response()->json($factura);
    }
}
