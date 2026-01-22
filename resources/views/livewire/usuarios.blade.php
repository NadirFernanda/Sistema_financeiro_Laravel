<div style="max-width:900px;margin:38px auto 0 auto;background:#fff;border-radius:22px;box-shadow:0 2px 16px rgba(24,119,242,0.10);padding:36px 36px 32px 36px;">
    @if ($isEdit || isset($showForm) && $showForm)
    <form wire:submit.prevent="save" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Nome" wire:model.defer="nome">
                @error('nome') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-4">
                <input type="email" class="form-control" placeholder="E-mail" wire:model.defer="email">
                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-3">
                <select class="form-select" wire:model.defer="role">
                    <option value="">Função</option>
                    <option value="admin">Admin</option>
                    <option value="financeiro">Financeiro</option>
                    <option value="usuario">Usuário</option>
                </select>
                @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">{{ $isEdit ? 'Atualizar' : 'Salvar' }}</button>
            </div>
        </div>
        <div class="mt-2">
            @if($isEdit)
                <button type="button" class="btn btn-secondary btn-sm" wire:click="resetForm">Cancelar</button>
            @endif
            @if($successMessage)
                <span class="text-success ms-3">{{ $successMessage }}</span>
            @endif
            @if($errorMessage)
                <span class="text-danger ms-3">{{ $errorMessage }}</span>
            @endif
        </div>
    </form>
    @endif
    <div style="display:flex;justify-content:flex-end;align-items:center;margin-bottom:12px;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="background:#1877F2;border:none;font-weight:600;font-size:1.08rem;border-radius:8px;padding:8px 22px;box-shadow:0 1px 6px rgba(24,119,242,0.10);">
            <i class="bi bi-arrow-left" style="margin-right:6px;"></i> Voltar ao Dashboard
        </a>
    </div>
    <h2 style="color:#1877F2;font-size:2.1rem;font-weight:700;margin-bottom:10px;">Gestão de Usuários</h2>
    <div style="color:#1877F2;font-size:1.18rem;font-weight:600;margin-bottom:8px;">Funções dos Usuários:</div>
    <div style="margin-bottom:22px;">
        <span style="color:#1877F2;font-weight:700;">Admin:</span> <span style="color:#222;">Acesso total ao sistema.</span><br>
        <span style="color:#1877F2;font-weight:700;">Contratação Pública:</span> <span style="color:#222;">Observa as despesas.</span><br>
        <span style="color:#1877F2;font-weight:700;">Executor:</span> <span style="color:#222;">Faz pagamento das despesas autorizadas.</span><br>
        <span style="color:#1877F2;font-weight:700;">Presidente:</span> <span style="color:#222;">Visualiza todas as despesas e autoriza pagamento.</span><br>
        <span style="color:#1877F2;font-weight:700;">Gabinete de apoio à presidência:</span> <span style="color:#222;">Visualiza todas as despesas e autoriza pagamento.</span>
    </div>
    <div style="display:flex;justify-content:flex-end;margin-bottom:18px;">
        <button class="btn btn-primary"
            style="background:#1877F2;border:none;font-weight:600;font-size:1.08rem;border-radius:8px;padding:8px 22px;box-shadow:0 1px 6px rgba(24,119,242,0.10);display:flex;align-items:center;"
            wire:click="create">
            <i class="bi bi-plus" style="margin-right:6px;"></i> Adicionar Usuário
        </button>
    </div>
    <div style="overflow-x:auto;">
        <table style="width:100%;border-radius:12px;overflow:hidden;box-shadow:0 1px 6px rgba(24,119,242,0.06);">
            <thead>
                <tr style="background:#1877F2;color:#fff;font-size:1.08rem;">
                    <th style="padding:12px 0;font-weight:700;">Nome</th>
                    <th style="padding:12px 0;font-weight:700;">Email</th>
                    <th style="padding:12px 0;font-weight:700;">Função</th>
                    <th style="padding:12px 0;font-weight:700;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr style="background:#f4f6fa;">
                        <td style="padding:10px 0;">{{ $usuario->nome }}</td>
                        <td style="padding:10px 0;">{{ $usuario->email }}</td>
                        <td style="padding:10px 0;">{{ $usuario->role }}</td>
                        <td style="padding:10px 0;">
                            <button class="btn btn-sm" style="background:#1877F2;color:#fff;font-weight:600;border:none;border-radius:6px;padding:4px 14px 4px 14px;box-shadow:0 1px 4px rgba(24,119,242,0.07);margin-right:4px;" wire:click="edit({{ $usuario->id }})">Editar</button>
                            <button class="btn btn-sm" style="background:#e74c3c;color:#fff;font-weight:600;border:none;border-radius:6px;padding:4px 14px 4px 14px;box-shadow:0 1px 4px rgba(24,119,242,0.07);" wire:click="delete({{ $usuario->id }})" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#888;font-size:1.1rem;padding:16px 0;">Nenhum usuário cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Se este arquivo está sendo incluído diretamente, troque por: --}}
{{-- @livewire('usuarios') --}}
