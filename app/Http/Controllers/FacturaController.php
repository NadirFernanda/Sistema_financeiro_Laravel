<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FacturaNotification;
use App\Models\Factura;
use App\Models\User;
use Illuminate\Http\Request;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Listar faturas
    public function index()
    {
        $facturas = Factura::orderBy('id')->get();
        return response()->json(['facturas' => $facturas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Adicionar fatura
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'descricao' => 'nullable',
                'valor' => 'nullable|numeric',
                'status' => 'nullable|string',
                'user_id' => 'nullable|exists:usuarios,id',
                'arquivo' => 'nullable|file',
            ]);

            if ($request->hasFile('arquivo')) {
                $path = $request->file('arquivo')->store('uploads');
                $validated['arquivo'] = $path;
            }

            $factura = Factura::create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Fatura salva com sucesso!',
                'factura' => $factura
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao salvar fatura.',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    // Exibir fatura específica
    public function show($id)
    {
        $factura = Factura::findOrFail($id);
        return response()->json(['factura' => $factura]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Editar fatura
    public function update(Request $request, $id)
    {
        // Buscar pelo campo correto (numero_factura)
        $factura = Factura::where('numero_factura', $id)->firstOrFail();
        $validated = $request->validate([
            'numero_factura' => 'required|unique:facturas,numero_factura,' . $factura->numero_factura . ',numero_factura',
            'empresa_nome' => 'nullable',
            'tipo_servico' => 'nullable',
            'natureza' => 'nullable',
            'tipologia' => 'required',
            'data_execucao' => 'nullable|date',
            'data_pagamento' => 'nullable|date',
            'valor_total' => 'nullable|numeric',
            'valor_pago' => 'nullable|numeric',
            'observacoes' => 'nullable',
            'arquivo' => 'nullable|file',
            'status' => 'nullable|string',
        ], [
            'numero_factura.required' => 'O campo número da fatura é obrigatório.',
            'numero_factura.unique' => 'Já existe uma fatura com este número.',
            'empresa_nome.required' => 'O campo empresa é obrigatório.',
            'tipo_servico.required' => 'O campo tipo de serviço é obrigatório.',
            'natureza.required' => 'O campo natureza é obrigatório.',
            'tipologia.required' => 'O campo tipologia é obrigatório.',
            'data_execucao.date' => 'A data de execução deve ser uma data válida.',
            'data_pagamento.date' => 'A data de pagamento deve ser uma data válida.',
            'valor_total.numeric' => 'O valor total deve ser numérico.',
            'valor_pago.numeric' => 'O valor pago deve ser numérico.',
            'arquivo.file' => 'O arquivo deve ser um ficheiro válido.',
            'status.string' => 'O status deve ser um texto.',
        ]);

        if ($request->hasFile('arquivo')) {
            $path = $request->file('arquivo')->store('uploads');
            $validated['arquivo'] = $path;
        }

        $factura->update($validated);
        return response()->json(['factura' => $factura]);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Excluir fatura
    public function destroy($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->delete();
        return response()->json(['success' => true]);
    }

    // Aprovar fatura
    public function aprovar($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->status = 'autorizada';
        $factura->save();
        return response()->json(['success' => true]);
    }

    // Rejeitar fatura
    public function rejeitar($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->status = 'rejeitada';
        $factura->save();
        return response()->json(['success' => true]);
    }

    // Revisar fatura
    public function revisar($id)
    {
        $factura = Factura::findOrFail($id);
        $factura->status = 'revisao';
        $factura->save();
        return response()->json(['success' => true]);
    }
}
