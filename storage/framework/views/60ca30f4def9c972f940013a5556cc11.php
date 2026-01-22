<div class="container" style="max-width:1200px;margin:auto;padding:32px 0;">
    <script>
        window.addEventListener('fatura-salva', () => {
            // Exemplo: scroll para tabela ou exibir alerta
            // alert('Fatura salva com sucesso!');
            // location.reload(); // Se necessário, recarrega a página
        });
    </script>
    <div style="margin-bottom:18px;">
        <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-outline-primary" style="border-radius:8px;padding:8px 22px;font-weight:500;font-size:1rem;">
            &#8592; Voltar
        </a>
    </div>
    <div style="margin-bottom:32px;">
        <h2 style="color:#1877F2;font-size:2.2rem;font-weight:700;margin-bottom:0.2rem;font-family:'Inter','Roboto',Arial,sans-serif;">Módulo financeiro</h2>
        <div style="color:#6c757d;font-size:1.15rem;">Sistema de despesas e controle de faturas.</div>
    </div>

    <div style="background:#1877F2;border-radius:20px;padding:24px 32px;margin-bottom:24px;box-shadow:0 2px 12px rgba(24,119,242,0.08);">
        <h3 style="color:#fff;font-size:1.4rem;font-weight:600;margin:0;">Faturas Recebidas</h3>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($successMessage): ?>
        <div class="alert alert-success"><?php echo e($successMessage); ?></div>
    <?php elseif($errorMessage): ?>
        <div class="alert alert-danger"><?php echo e($errorMessage); ?></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div style="background:#fff;border-radius:16px;padding:18px 24px;margin-bottom:24px;box-shadow:0 2px 8px rgba(24,119,242,0.04);display:flex;align-items:center;gap:12px;">
        <input type="text" class="form-control" wire:model.defer="pesquisa_numero" placeholder="Pesquisar por Nº da Fatura" style="border-radius:8px;border:1.5px solid #e3f0ff;padding:10px 16px;font-size:1rem;max-width:260px;">
        <button class="btn" wire:click="pesquisarFatura" style="background:#1877F2;color:#fff;font-weight:500;border:none;border-radius:8px;padding:10px 24px;font-size:1rem;transition:background 0.2s;">Pesquisar</button>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-bottom:16px;">
        <button class="btn" style="background:#1877F2;color:#fff;font-weight:500;border:none;border-radius:8px;padding:10px 24px;font-size:1rem;transition:background 0.2s;" wire:click="toggleForm">Adicionar Fatura</button>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showForm): ?>
        <div class="card mb-4 shadow-lg border-0 mx-auto" style="border-radius:22px;background:#f8faff;padding:32px 28px 18px 28px;max-width:700px;">
            <div class="card-body p-0">
                <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Nº Fatura</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="numero_factura" placeholder="Ex: 2025-001">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['numero_factura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Empresa</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="empresa_nome" placeholder="Nome da empresa">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['empresa_nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Tipo Serviço</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="tipo_servico" placeholder="Tipo de serviço">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tipo_servico'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Natureza</label>
                            <select class="form-select form-select-lg rounded-3 shadow-sm" wire:model.defer="natureza">
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['natureza'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Tipologia</label>
                            <select class="form-select form-select-lg rounded-3 shadow-sm" wire:model.defer="tipologia">
                                <option value="">Selecione</option>
                                <option value="Factura recibo">Factura recibo</option>
                                <option value="Proforma">Proforma</option>
                                <option value="Factura">Factura</option>
                                <option value="Recibo">Recibo</option>
                                <option value="Nota de entrega">Nota de entrega</option>
                            </select>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['tipologia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Data Execução</label>
                            <input type="date" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="data_execucao">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['data_execucao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Data Pagamento</label>
                            <input type="date" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="data_pagamento">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['data_pagamento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Valor Total</label>
                            <input type="number" step="0.01" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="valor_total" placeholder="0.00">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Valor Pago</label>
                            <input type="number" step="0.01" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="valor_pago" placeholder="0.00">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['valor_pago'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Observações</label>
                            <input type="text" class="form-control form-control-lg rounded-3 shadow-sm" wire:model.defer="observacoes" placeholder="Observações">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['observacoes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Arquivo</label>
                            <div style="position:relative;">
                                <label for="arquivo-upload" class="btn btn-outline-secondary" style="min-width:160px;">
                                    Escolher arquivo
                                </label>
                                <input id="arquivo-upload" type="file" style="opacity:0;position:absolute;left:0;top:0;width:100%;height:100%;cursor:pointer;" wire:model="arquivo">
                                <span id="arquivo-nome" style="margin-left:12px;vertical-align:middle;">
                                    <?php echo e($arquivo ? (is_string($arquivo) ? $arquivo : (method_exists($arquivo, 'getClientOriginalName') ? $arquivo->getClientOriginalName() : 'Arquivo selecionado')) : 'Nenhum arquivo selecionado'); ?>

                                </span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['arquivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger small"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="col-12 mb-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" style="border-radius:10px;min-height:48px;background:#1877F2;border:none;">Adicionar</button>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEdit): ?>
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary btn-sm" wire:click="resetForm">Cancelar edição</button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </form>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <div style="background:#fff;border-radius:22px;padding:24px 32px;box-shadow:0 4px 24px rgba(24,119,242,0.10);margin-top:32px;">
        <table class="table mb-0" style="width:100%;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(24,119,242,0.04);">
            <thead style="background:#1877F2;color:#fff;font-weight:600;font-size:0.85rem;position:sticky;top:0;z-index:2;">
                <tr>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:75px;background:#1877F2;color:#fff;">Nº<br>Factura</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:75px;background:#1877F2;color:#fff;">Empresa</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:115px;background:#1877F2;color:#fff;">Tipo de<br>Serviço</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:105px;background:#1877F2;color:#fff;">Natureza</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:95px;background:#1877F2;color:#fff;">Tipologia</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:95px;background:#1877F2;color:#fff;">Data<br>Execução</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:95px;background:#1877F2;color:#fff;">Data<br>Pagamento</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:95px;background:#1877F2;color:#fff;">Valor<br>Total</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:95px;background:#1877F2;color:#fff;">Valor<br>Pago</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:105px;background:#1877F2;color:#fff;">Valor<br>Pendente</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:130px;background:#1877F2;color:#fff;">Observações</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:75px;background:#1877F2;color:#fff;">Status</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:75px;background:#1877F2;color:#fff;">Arquivo</th>
                    <th style="padding:16px 10px;white-space:normal;word-break:break-word;min-width:75px;background:#1877F2;color:#fff;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $faturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fatura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="background:<?php if($loop->index % 2 == 0): ?>#f4f8ff;<?php else: ?> #fff;<?php endif; ?>">
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->numero_factura); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->empresa_nome); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->tipo_servico); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->natureza); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->tipologia); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->data_execucao); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->data_pagamento); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->valor_total); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->valor_pago); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->valor_pendente); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->observacoes); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;"><?php echo e($fatura->status); ?></td>
                        <td style="padding:14px 10px;vertical-align:middle;font-size:0.85rem;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fatura->arquivo): ?>
                                <a href="<?php echo e(asset('storage/' . $fatura->arquivo)); ?>" target="_blank" style="color:#1877F2;font-weight:500;text-decoration:underline;">Ver arquivo</a>
                            <?php else: ?>
                                <span style="color:#bbb;">-</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td style="padding:14px 10px;vertical-align:middle;">
                            <div style="display:flex;flex-direction:column;align-items:flex-start;gap:8px;">
                                <button class="btn btn-sm" style="background:#1877F2;color:#fff;border:none;border-radius:8px;padding:7px 18px;font-weight:600;transition:background 0.2s;cursor:pointer;z-index:10;position:relative;" wire:click="edit('<?php echo e($fatura->numero_factura); ?>')">Editar</button>
                                <button class="btn btn-sm" style="background:#e74c3c;color:#fff;border:none;border-radius:8px;padding:7px 18px;font-weight:600;transition:background 0.2s;cursor:pointer;z-index:10;position:relative;"
                                    onclick="return confirm('Tem certeza que deseja excluir esta fatura?')"
                                    wire:click="delete('<?php echo e($fatura->numero_factura); ?>')">
                                    Excluir
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="15" class="text-center" style="padding:32px 0;color:#6c757d;font-size:1.1rem;">Nenhuma fatura cadastrada.</td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH C:\Users\Administrator\Documents\INVOICE_LARAVEL - PRODUÇÃO\backend-laravel10\resources\views/livewire/faturas.blade.php ENDPATH**/ ?>