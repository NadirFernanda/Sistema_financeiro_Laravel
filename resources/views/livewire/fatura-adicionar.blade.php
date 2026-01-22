
<div class="container mt-5" style="max-width:700px;">
    <h2 style="color:#1877F2;font-weight:700;">Adicionar Fatura</h2>
    @if ($successMessage)
        <div class="alert alert-success">{{ $successMessage }}</div>
    @endif
    @if ($errorMessage)
        <div class="alert alert-danger">{{ $errorMessage }}</div>
    @endif
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label class="form-label">Número da Fatura *</label>
            <input type="text" class="form-control" wire:model.defer="numero_factura">
            @error('numero_factura') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Empresa</label>
            <input type="text" class="form-control" wire:model.defer="empresa_nome">
            @error('empresa_nome') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo de Serviço</label>
            <input type="text" class="form-control" wire:model.defer="tipo_servico">
            @error('tipo_servico') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Natureza *</label>
            <input type="text" class="form-control" wire:model.defer="natureza">
            @error('natureza') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Tipologia *</label>
            <input type="text" class="form-control" wire:model.defer="tipologia">
            @error('tipologia') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Data de Execução</label>
            <input type="date" class="form-control" wire:model.defer="data_execucao">
            @error('data_execucao') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Data de Pagamento</label>
            <input type="date" class="form-control" wire:model.defer="data_pagamento">
            @error('data_pagamento') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Valor Total</label>
            <input type="number" step="0.01" class="form-control" wire:model.defer="valor_total">
            @error('valor_total') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Valor Pago</label>
            <input type="number" step="0.01" class="form-control" wire:model.defer="valor_pago">
            @error('valor_pago') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Observações</label>
            <textarea class="form-control" wire:model.defer="observacoes"></textarea>
            @error('observacoes') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Arquivo (PDF, JPG, PNG, até 2MB)</label>
            <input type="file" class="form-control" wire:model="arquivo">
            @error('arquivo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Adicionar Fatura</button>
    </form>
</div>
