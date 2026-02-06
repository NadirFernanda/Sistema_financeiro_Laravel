<div style="background:#f4f6fa;min-height:100vh;padding:0 0 32px 0;">
    <div style="display:flex;justify-content:flex-start;align-items:center;padding:24px 0 0 36px;max-width:98vw;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary" style="background:#1877F2;border:none;font-weight:600;font-size:1.08rem;border-radius:8px;padding:8px 22px;box-shadow:0 1px 6px rgba(24,119,242,0.10);">
            <i class="bi bi-arrow-left" style="margin-right:6px;"></i> Voltar ao Dashboard
        </a>
    </div>
    <div style="background:#1877F2;color:#fff;font-size:2rem;font-weight:700;padding:28px 36px 18px 36px;border-radius:22px 22px 24px 24px;box-shadow:0 2px 12px rgba(24,119,242,0.10);margin:32px 0 32px 0;max-width:98vw;">
        Plano de caixa
    </div>
    <div class="row mb-4" style="gap:18px;justify-content:center;">
        <div class="col-md-3" style="min-width:260px;">
            <div style="background:#f4faff;border-radius:18px;padding:28px 24px;box-shadow:0 2px 12px rgba(24,119,242,0.08);display:flex;flex-direction:column;align-items:flex-start;">
                <span style="color:#1ca65c;font-weight:600;font-size:1.1rem;">Entradas</span>
                <span style="color:#1877F2;font-size:2rem;font-weight:700;">Kz {{ number_format($total_entradas, 2, ',', '.') }}</span>
            </div>
        </div>
        <div class="col-md-3" style="min-width:260px;">
            <div style="background:#f4faff;border-radius:18px;padding:28px 24px;box-shadow:0 2px 12px rgba(24,119,242,0.08);display:flex;flex-direction:column;align-items:flex-start;">
                <span style="color:#e74c3c;font-weight:600;font-size:1.1rem;">Saídas</span>
                <span style="color:#1877F2;font-size:2rem;font-weight:700;">Kz {{ number_format($total_saidas, 2, ',', '.') }}</span>
            </div>
        </div>
        <div class="col-md-3" style="min-width:260px;">
            <div style="background:#f4faff;border-radius:18px;padding:28px 24px;box-shadow:0 2px 12px rgba(24,119,242,0.08);display:flex;flex-direction:column;align-items:flex-start;">
                <span style="color:#1ca65c;font-weight:600;font-size:1.1rem;">Saldo</span>
                <span style="color:#1877F2;font-size:2rem;font-weight:700;">Kz {{ number_format($saldo, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if ($mensagem)
        <div class="alert alert-success">{{ $mensagem }}</div>
    @endif

    @if($this->podeInserir)
        {{-- Formulário de cadastro de movimento --}}
        <form wire:submit.prevent="salvarMovimento" class="row g-3 mb-4">
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Empresa" wire:model.defer="empresa">
                @error('empresa') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" placeholder="Descrição da Despesa" wire:model.defer="descricao">
                @error('descricao') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <select class="form-select" wire:model.defer="natureza_pagamento">
                    <option value="">Selecione</option>
                    <option value="Abono De Família Subsídios Do Pessoal Civil">Abono De Família Subsídios Do Pessoal Civil</option>
                    <option value="Aquisição De Mobiliário">Aquisição De Mobiliário</option>
                    <option value="Bilhetes De Passagem">Bilhetes De Passagem</option>
                    <option value="Combustíveis E Lubrificantes">Combustíveis E Lubrificantes</option>
                    <option value="Contribuições Do Empregador Para A Segurança Social">Contribuições Do Empregador Para A Segurança Social</option>
                    <option value="Décimo Terceiro Mês Do Pessoal Civil">Décimo Terceiro Mês Do Pessoal Civil</option>
                    <option value="Encargos Aduaneiros E Portuários">Encargos Aduaneiros E Portuários</option>
                    <option value="Material De Consumo Corrente Especializado">Material De Consumo Corrente Especializado</option>
                    <option value="Materiais E Utensílios Duradouros De Especialidade">Materiais E Utensílios Duradouros De Especialidade</option>
                    <option value="Outros Materiais De Consumo Corrente">Outros Materiais De Consumo Corrente</option>
                    <option value="Outros Materiais E Utensilios Duradouros">Outros Materiais E Utensilios Duradouros</option>
                    <option value="Outros Serviços">Outros Serviços</option>
                    <option value="Rendas De Imoveis">Rendas De Imoveis</option>
                    <option value="Seguros">Seguros</option>
                    <option value="Serviço De Protecção E Vigilância">Serviço De Protecção E Vigilância</option>
                    <option value="Serviços De Água E Electricidade">Serviços De Água E Electricidade</option>
                    <option value="Serviços De Ensino E Formação">Serviços De Ensino E Formação</option>
                    <option value="Serviços De Hospedagem E Alimentação">Serviços De Hospedagem E Alimentação</option>
                    <option value="Serviços De Limpeza E Saneamento">Serviços De Limpeza E Saneamento</option>
                    <option value="Serviços De Manutenção E Conservação">Serviços De Manutenção E Conservação</option>
                    <option value="Serviços De Processamento De Dados">Serviços De Processamento De Dados</option>
                    <option value="Serviços De Saúde">Serviços De Saúde</option>
                    <option value="Serviços De Telecomunicação">Serviços De Telecomunicação</option>
                    <option value="Serviços De Transportação De Pessoas E Bens">Serviços De Transportação De Pessoas E Bens</option>
                    <option value="Subsídios De Deslocação">Subsídios De Deslocação</option>
                    <option value="Víveres E Géneros Alimentícios">Víveres E Géneros Alimentícios</option>
                    <option value="Vencimentos De Outro Pessoal Civil">Vencimentos De Outro Pessoal Civil</option>
                </select>
                @error('natureza_pagamento') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" class="form-control" placeholder="Valor (Kz)" wire:model.defer="valor">
                @error('valor') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <select class="form-select" wire:model.defer="fonte_financiamento">
                    <option value="">Selecione a Fonte</option>
                    <option value="RP">RP</option>
                    <option value="ROT">ROT</option>
                </select>
                @error('fonte_financiamento') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <input type="datetime-local" class="form-control" wire:model.defer="data_cadastro">
                @error('data_cadastro') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-2">
                <select class="form-select" wire:model.live="tipo">
                    <option value="entrada">Entrada</option>
                    <option value="saida">Saída</option>
                </select>
                @error('tipo') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            {{-- Campo de fatura só aparece quando o tipo é Saída --}}
            @if ($tipo === 'saida')
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="factura_id">
                        <option value="">Selecione a Fatura (obrigatória para Saída)</option>
                        @foreach ($facturas as $fatura)
                            <option value="{{ $fatura->numero_factura }}">{{ $fatura->numero_factura }} - {{ $fatura->empresa_nome }}</option>
                        @endforeach
                    </select>
                    @error('factura_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            @endif
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    {{ $modoEdicao ? 'Atualizar' : 'Cadastrar' }}
                </button>
            </div>
        </form>
    @endif

    {{-- Filtro por data --}}
    <form wire:submit.prevent="filtrarPorData" class="row g-2 mb-3 align-items-end">
        <div class="col-auto">
            <label style="color:#4a5a6a;font-weight:500;">De</label>
            <input type="date" class="form-control" wire:model.defer="data_inicio" style="background:#e9eef6;border:1px solid #d3dbe7;color:#222;">
        </div>
        <div class="col-auto">
            <label style="color:#4a5a6a;font-weight:500;">Até</label>
            <input type="date" class="form-control" wire:model.defer="data_fim" style="background:#e9eef6;border:1px solid #d3dbe7;color:#222;">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn" style="background:#e9eef6;color:#1877F2;font-weight:600;border:none;">Filtrar</button>
        </div>
        <div class="col-auto">
            <button type="button" class="btn" style="background:#f4f6fa;color:#1877F2;font-weight:600;border:1px solid #e9eef6;" wire:click="resetarFormulario">Limpar</button>
        </div>
    </form>

    {{-- Tabela de movimentos --}}
    <div class="table-responsive" style="border-radius:18px;box-shadow:0 2px 16px rgba(24,119,242,0.10);overflow-x:auto;margin-top:18px;padding-bottom:16px;padding-right:24px;">
        <table class="table align-middle mb-0" style="background:#fff;border-radius:18px;overflow:hidden;">
            <thead style="background:#1877F2;color:#fff;">
                <tr style="font-size:0.98rem;">
                    <th style="border:none;background:#1877F2;color:#fff;">Nº Ordem</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Empresa</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Descrição</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Natureza</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Valor (Kz)</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Fonte</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Fatura Associada</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Data Cadastro</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Tipo</th>
                    <th style="border:none;background:#1877F2;color:#fff;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($movimentos as $mov)
                    <tr style="transition:background 0.2s;">
                        <td style="font-weight:600;">{{ $mov->numero_ordem }}</td>
                        <td>{{ $mov->empresa }}</td>
                        <td>{{ $mov->descricao }}</td>
                        <td><span class="badge" style="background:#eaf1fb;color:#1877F2;font-weight:500;font-size:0.98rem;">{{ $mov->natureza_pagamento }}</span></td>
                        <td style="font-weight:600;color:#1877F2;">Kz {{ number_format($mov->valor, 2, ',', '.') }}</td>
                        <td><span class="badge" style="background:#e9eef6;color:#1877F2;font-size:0.97rem;font-weight:600;">{{ $mov->fonte_financiamento }}</span></td>
                        <td>
                            @if($mov->factura && $mov->factura->id && $mov->factura->numero_factura)
                                <a href="{{ route('facturas.show', $mov->factura->id) }}" target="_blank" style="color:#1877F2;text-decoration:underline;font-weight:500;">{{ $mov->factura->numero_factura }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($mov->data_cadastro)->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="badge" style="background:{{ $mov->tipo == 'entrada' ? '#1ca65c' : '#e74c3c' }};color:#fff;font-size:1rem;font-weight:600;min-width:70px;display:inline-block;">{{ ucfirst($mov->tipo) }}</span>
                        </td>
                        <td>
                            @if(auth()->user()->papel !== 'contratacao')
                                @if($this->podeEditar)
                                    <button class="btn btn-sm" style="background:#1877F2;color:#fff;font-weight:600;border:none;border-radius:6px;padding:4px 14px 4px 14px;box-shadow:0 1px 4px rgba(24,119,242,0.07);margin-right:4px;" wire:click="editarMovimento({{ $mov->id }})">Editar</button>
                                @endif
                                @if($this->podeEliminar)
                                    <button class="btn btn-sm" style="background:#e74c3c;color:#fff;font-weight:600;border:none;border-radius:6px;padding:4px 14px 4px 14px;box-shadow:0 1px 4px rgba(24,119,242,0.07);" wire:click="excluirMovimento({{ $mov->id }})" onclick="return confirm('Tem certeza?')">Excluir</button>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center" style="color:#888;font-size:1.1rem;">Nenhum movimento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
