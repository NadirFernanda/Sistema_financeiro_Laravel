<div>
<div>
    <div style="margin-bottom:18px;">
        <a href="/dashboard" class="btn" style="background:#1877F2;color:#fff;font-weight:600;font-size:1.12rem;border-radius:18px;padding:10px 28px;box-shadow:0 1px 6px rgba(24,119,242,0.10);text-decoration:none;display:inline-block;">
            ← Voltar ao Dashboard
        </a>
    </div>

    <!-- Gráfico de Despesas por Natureza (filtro por intervalo de datas) -->
    <div style="width:100%;background:#fff;border-radius:18px;margin-bottom:24px;padding:32px 18px 24px 18px;box-shadow:0 2px 16px rgba(24,119,242,0.07);">
        <h2 style="color:#0074D9;font-size:2.1rem;font-weight:700;margin-bottom:8px;text-align:left;">Gráfico de Despesas por Natureza</h2>
        <div style="display:flex;gap:12px;align-items:center;margin-bottom:12px;flex-wrap:wrap;">
            <span style="font-weight:600;">Informe o período:</span>
            <label for="dataInicioNatureza" style="font-weight:600;">Início:</label>
            <input id="dataInicioNatureza" type="date" wire:model="data_inicio_grafico" style="padding:4px 10px;border-radius:8px;border:1px solid #ccc;">
            <label for="dataFimNatureza" style="font-weight:600;">Fim:</label>
            <input id="dataFimNatureza" type="date" wire:model="data_fim_grafico" style="padding:4px 10px;border-radius:8px;border:1px solid #ccc;">
            <button wire:click="filtrarGraficoMesCorrente" class="btn" style="background:#1877F2;color:#fff;font-weight:600;padding:4px 18px;border-radius:8px;">Filtrar</button>
        </div>
        @if($mensagemFiltro)
        <div style="margin-bottom:12px;color:#e65c1a;font-size:0.98rem;background:#fffbe6;padding:8px 16px;border-radius:8px;max-width:900px;">
            {{ $mensagemFiltro }}
        </div>
        @endif
        <h3 style="color:#1877F2;font-size:1.2rem;font-weight:700;margin-bottom:18px;text-align:left;">Despesas por Natureza no período selecionado</h3>
        <div style="width:100%;min-height:220px;background:#f4f6fa;border-radius:16px;margin-bottom:24px;display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <canvas id="graficoMesCorrente" style="max-width:900px;width:100%;height:220px;"></canvas>
        </div>
        <button id="btnDownloadGraficoMesCorrente" class="btn" style="background:#00bfff;color:#fff;font-weight:600;font-size:1.08rem;border-radius:22px;padding:6px 24px;box-shadow:0 1px 6px rgba(24,119,242,0.10);margin-bottom:10px;align-self:flex-end;" onclick="baixarGraficoMesCorrente()">Baixar Gráfico (PNG)</button>
    </div>

    <!-- Chart.js deve ser carregado antes de qualquer uso -->
    <script src="{{ asset('js/chart.umd.js') }}"></script>

    <style>
        .relatorio-filtro-link {
            background: #f4f6fa;
            color: #222;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            padding: 8px 22px;
            font-size: 1.08rem;
            box-shadow: none;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            display: inline-block;
            margin-right: 12px;
        }
        .relatorio-filtro-link.ativo {
            background: #F4F6FA;
            font-weight: 700;
        }
        .relatorio-filtro-link:hover, .relatorio-filtro-link:focus {
            background: #1877F2;
            color: #fff;
        }
    </style>

    <!-- Seção: Relatório de Dívidas (Pendentes e Parciais) -->
    <div style="max-width:1200px;margin:38px auto 0 auto;background:#fff;border-radius:22px;box-shadow:0 2px 16px rgba(24,119,242,0.10);padding:36px 36px 32px 36px;">
        <h2 style="color:#1877F2;font-size:2.1rem;font-weight:700;margin-bottom:2px;">Relatório de Dívidas (Pendentes e Parciais)</h2>
        <div style="overflow-x:auto;border-radius:22px;box-shadow:0 2px 16px rgba(24,119,242,0.10);background:#fff;margin-bottom:18px;">
            <table style="width:100%;border-radius:22px;overflow:hidden;box-shadow:none;margin-bottom:0;font-size:0.97rem;">
                <thead>
                    <tr style="background:#1877F2;color:#fff;font-size:1.01rem;">
                        <th style="padding:12px 10px;font-weight:700;min-width:90px;">Nº Factura</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;">Empresa</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;">Tipo de Serviço</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;">Natureza</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:110px;">Valor Pendente</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:80px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($dividas) && count($dividas))
                        @foreach($dividas as $f)
                            <tr>
                                <td>{{ $f->numero_factura ?? $f->id }}</td>
                                <td>{{ $f->empresa_nome ?? '' }}</td>
                                <td>{{ $f->tipo_servico ?? '' }}</td>
                                <td>{{ $f->natureza ?? '' }}</td>
                                <td>{{ number_format($f->valor_pendente ?? 0, 2, ',', '.') }} Kz</td>
                                <td>{{ ucfirst($f->status ?? '') }}</td>
                            </tr>
                        @endforeach
                        <tr style="background:#f4f6fa;font-weight:700;">
                            <td colspan="3" style="text-align:right;">Total da Dívida:</td>
                            <td style="color:#e65c1a;">{{ number_format($totalDividas, 2, ',', '.') }} Kz</td>
                            <td></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" style="text-align:center;color:#888;font-size:1.1rem;padding:16px 0;">Nenhuma dívida encontrada.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div style="display:flex;justify-content:flex-end;margin-bottom:24px;">
            <button class="btn" wire:click="exportarExcelDividas" style="background:#1877F2;color:#fff;font-weight:600;font-size:1.08rem;border-radius:22px;padding:8px 32px;box-shadow:0 1px 6px rgba(24,119,242,0.10);display:flex;align-items:center;gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Baixar Excel
            </button>
        </div>

        <h2 style="color:#1877F2;font-size:1.7rem;font-weight:700;margin-bottom:12px;">Gráfico de Dívidas por Natureza</h2>
        <div style="width:100%;min-height:220px;background:#f4f6fa;border-radius:16px;margin-bottom:24px;display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <canvas id="graficoDividasNatureza" style="max-width:900px;width:100%;height:220px;"></canvas>
            <div id="debugGraficoDividasNatureza" style="margin-top:12px;color:#e65c1a;font-size:0.98rem;background:#fffbe6;padding:8px 16px;border-radius:8px;max-width:900px;width:100%;word-break:break-all;display:none;"></div>
        </div>
        <button id="btnDownloadGraficoDividasNatureza" class="btn" style="background:#e65c1a;color:#fff;font-weight:600;font-size:1.08rem;border-radius:22px;padding:6px 24px;box-shadow:0 1px 6px rgba(24,119,242,0.10);margin-bottom:10px;align-self:flex-end;" onclick="baixarGraficoDividasNatureza()">Baixar Gráfico (PNG)</button>
    </div>

    <!-- Seção: Relatório de Faturas -->
    <div style="max-width:1200px;margin:38px auto 0 auto;background:#fff;border-radius:22px;box-shadow:0 2px 16px rgba(24,119,242,0.10);padding:36px 36px 32px 36px;">
        <h2 style="color:#1877F2;font-size:2.1rem;font-weight:700;margin-bottom:12px;">Relatório de Faturas</h2>
        <div style="margin:18px 0 18px 0;">
            <a href="#" wire:click.prevent="filtrar('todos')" class="relatorio-filtro-link {{ $filtro === 'todos' ? 'ativo' : '' }}" style="font-size:1.18rem;">Todas</a>
            <a href="#" wire:click.prevent="filtrar('pendente')" class="relatorio-filtro-link {{ $filtro === 'pendente' ? 'ativo' : '' }}" style="font-size:1.18rem;">Pendentes</a>
            <a href="#" wire:click.prevent="filtrar('parcial')" class="relatorio-filtro-link {{ $filtro === 'parcial' ? 'ativo' : '' }}" style="font-size:1.18rem;">Parciais</a>
            <a href="#" wire:click.prevent="filtrar('pago')" class="relatorio-filtro-link {{ $filtro === 'pago' ? 'ativo' : '' }}" style="font-size:1.18rem;">Pagas</a>
            <a href="#" wire:click.prevent="filtrar('aprovada')" class="relatorio-filtro-link {{ $filtro === 'aprovada' ? 'ativo' : '' }}" style="font-size:1.18rem;">Aprovadas</a>
            <a href="#" wire:click.prevent="filtrar('reprovada')" class="relatorio-filtro-link {{ $filtro === 'reprovada' ? 'ativo' : '' }}" style="font-size:1.18rem;">Reprovadas</a>
            <a href="#" wire:click.prevent="filtrar('revisao')" class="relatorio-filtro-link {{ $filtro === 'revisao' ? 'ativo' : '' }}" style="font-size:1.18rem;">Revisão</a>
        </div>
        <div style="overflow-x:auto;border-radius:22px;box-shadow:0 2px 16px rgba(24,119,242,0.10);background:#fff;margin-bottom:18px;">
            <table style="width:100%;border-radius:22px;overflow:hidden;box-shadow:none;margin-bottom:0;font-size:0.97rem;">
                <thead>
                    <tr style="background:#1877F2;color:#fff;font-size:1.01rem;">
                        <th style="padding:12px 10px;font-weight:700;min-width:90px;">Nº Factura</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;">Empresa</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;">Tipo de Serviço</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;">Natureza</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:100px;">Tipologia</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:110px;">Data de Entrada</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:110px;">Data de Pagamento</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:90px;">Valor Total</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:90px;">Valor Pago</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:110px;">Valor Pendente</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:120px;word-break:break-word;">Observações</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:100px;word-break:break-word;">Arquivo</th>
                        <th style="padding:12px 10px;font-weight:700;min-width:80px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($faturas) > 0)
                        @foreach($faturas as $f)
                            <tr>
                                <td>{{ $f->numero_factura ?? $f->id }}</td>
                                <td>{{ $f->empresa_nome ?? '' }}</td>
                                <td>{{ $f->tipo_servico ?? '' }}</td>
                                <td>{{ $f->natureza ?? '' }}</td>
                                <td>{{ $f->tipologia ?? '' }}</td>
                                <td>{{ $f->data_execucao ?? $f->data_entrada ?? '' }}</td>
                                <td>{{ $f->data_pagamento ?? '' }}</td>
                                <td>{{ number_format($f->valor_total ?? 0, 2, ',', '.') }} Kz</td>
                                <td>{{ number_format($f->valor_pago ?? 0, 2, ',', '.') }} Kz</td>
                                <td>{{ number_format($f->valor_pendente ?? 0, 2, ',', '.') }} Kz</td>
                                <td>{{ $f->observacoes ?? '' }}</td>
                                <td>{{ $f->arquivo ?? '' }}</td>
                                <td>{{ $f->status ?? '' }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="13" style="text-align:center;color:#888;font-size:1.1rem;padding:16px 0;">Nenhuma fatura encontrada.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div style="display:flex;justify-content:flex-end;">
            <button class="btn" wire:click="exportarExcel" style="background:#1877F2;color:#fff;font-weight:600;font-size:1.08rem;border-radius:22px;padding:8px 32px;box-shadow:0 1px 6px rgba(24,119,242,0.10);display:flex;align-items:center;gap:8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Baixar Excel
            </button>
        </div>
    </div>

    <!-- Scripts dos gráficos -->
    <script>
        function baixarGraficoDividasNatureza() {
            const canvas = document.getElementById('graficoDividasNatureza');
            if (!canvas) return;
            const tmpCanvas = document.createElement('canvas');
            tmpCanvas.width = canvas.width;
            tmpCanvas.height = canvas.height;
            const ctx = tmpCanvas.getContext('2d');
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, tmpCanvas.width, tmpCanvas.height);
            ctx.drawImage(canvas, 0, 0);
            const link = document.createElement('a');
            link.href = tmpCanvas.toDataURL('image/png');
            link.download = 'grafico_dividas_natureza.png';
            link.click();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dividasNaturezaLabels = @json($dividasNaturezaLabels);
            const dividasNaturezaValores = @json($dividasNaturezaValores);
            const canvasDividas = document.getElementById('graficoDividasNatureza');
            const debugDivDividas = document.getElementById('debugGraficoDividasNatureza');
            if (debugDivDividas) {
                debugDivDividas.style.display = 'none';
            }
            if (canvasDividas && window.Chart) {
                const valoresNumericos = Array.isArray(dividasNaturezaValores) ? dividasNaturezaValores.map(v => Number(v)) : [];

                // Plugin simples para desenhar rótulos com o valor exato sobre cada barra
                const valueLabelPlugin = {
                    id: 'valueLabelPlugin',
                    afterDatasetsDraw: (chart, args, options) => {
                        const ctx = chart.ctx;
                        chart.data.datasets.forEach((dataset, dsIndex) => {
                            const meta = chart.getDatasetMeta(dsIndex);
                            meta.data.forEach((element, index) => {
                                const value = dataset.data[index] ?? 0;
                                const formatted = Number(value).toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Kz';
                                const position = element.tooltipPosition();
                                ctx.save();
                                ctx.fillStyle = (options && options.color) ? options.color : '#0b1220';
                                ctx.font = (options && options.font) ? options.font : '12px "Segoe UI", Arial';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                if (chart.options && chart.options.indexAxis === 'y') {
                                    ctx.textAlign = 'left';
                                    ctx.fillText(formatted, position.x + 8, position.y);
                                } else {
                                    ctx.textBaseline = 'bottom';
                                    ctx.fillText(formatted, position.x, position.y - 6);
                                }
                                ctx.restore();
                            });
                        });
                    }
                };

                // Calcula um step 'amigável' para ticks baseado no maior valor
                const computeNiceStep = (max) => {
                    const targetTicks = 5;
                    if (!isFinite(max) || max <= 0) return 1;
                    const rawStep = max / targetTicks;
                    const mag = Math.pow(10, Math.floor(Math.log10(rawStep)));
                    const residual = rawStep / mag;
                    let step;
                    if (residual <= 1) step = 1 * mag;
                    else if (residual <= 2) step = 2 * mag;
                    else if (residual <= 5) step = 5 * mag;
                    else step = 10 * mag;
                    return step;
                };

                const maxVal = valoresNumericos.length ? Math.max(...valoresNumericos) : 0;
                const stepSize = computeNiceStep(maxVal);
                const suggestedMax = Math.ceil(maxVal / stepSize) * stepSize;

                new Chart(canvasDividas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dividasNaturezaLabels,
                        datasets: [{
                            label: 'Valor Pendente (Kz)',
                            data: valoresNumericos,
                            backgroundColor: '#ff9068',
                            borderRadius: 10,
                            maxBarThickness: 40,
                            hoverBackgroundColor: '#e65c1a'
                        }]
                    },
                    plugins: [valueLabelPlugin],
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.x || 0;
                                        return ' ' + value.toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Kz';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                suggestedMax: suggestedMax,
                                grid: { color: '#eef2f7' },
                                ticks: {
                                    color: '#e65c1a',
                                    font: { size: 13 },
                                    stepSize: stepSize,
                                    callback: function(value) {
                                        try {
                                            return Number(value).toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                        } catch (e) {
                                            return value;
                                        }
                                    }
                                }
                            },
                            y: {
                                grid: { color: '#f3f5fb' },
                                ticks: { color: '#e65c1a', font: { size: 13 } }
                            }
                        }
                    }
                });
            }
        });
    </script>

    <script>
        let mesCorrenteChartInstance = null;

        function renderGraficoMesCorrente(labels, valores) {
            const canvasMes = document.getElementById('graficoMesCorrente');
            if (!canvasMes) return;
            const ctx = canvasMes.getContext('2d');

            if (mesCorrenteChartInstance) {
                mesCorrenteChartInstance.destroy();
                mesCorrenteChartInstance = null;
            }
            if (window.Chart && Chart.getChart && Chart.getChart(canvasMes)) {
                Chart.getChart(canvasMes).destroy();
            }
            ctx.clearRect(0, 0, canvasMes.width, canvasMes.height);

            if (typeof window.Chart === 'undefined') {
                console.error('Chart.js não carregado (window.Chart undefined).');
                ctx.save();
                ctx.font = '16px "Segoe UI", Arial';
                ctx.fillStyle = '#e65c1a';
                ctx.textAlign = 'center';
                ctx.fillText('Erro ao carregar biblioteca de gráfico.', canvasMes.width / 2, canvasMes.height / 2);
                ctx.restore();
                return;
            }

            if (!Array.isArray(labels) || labels.length === 0 || !Array.isArray(valores) || valores.length === 0) {
                ctx.save();
                ctx.clearRect(0, 0, canvasMes.width, canvasMes.height);
                ctx.font = '18px "Segoe UI", Arial';
                ctx.fillStyle = '#e65c1a';
                ctx.textAlign = 'center';
                ctx.fillText('Nenhum dado disponível para o período selecionado.', canvasMes.width / 2, canvasMes.height / 2);
                ctx.restore();
                return;
            }

            const valoresNumericos = Array.isArray(valores) ? valores.map(v => Number(v)) : [];

            try {
                // calcula stepSize amigável para o eixo Y (valores das barras)
                const computeNiceStep = (max) => {
                    const targetTicks = 5;
                    if (!isFinite(max) || max <= 0) return 1;
                    const rawStep = max / targetTicks;
                    const mag = Math.pow(10, Math.floor(Math.log10(rawStep)));
                    const residual = rawStep / mag;
                    let step;
                    if (residual <= 1) step = 1 * mag;
                    else if (residual <= 2) step = 2 * mag;
                    else if (residual <= 5) step = 5 * mag;
                    else step = 10 * mag;
                    return step;
                };
                const maxVal = valoresNumericos.length ? Math.max(...valoresNumericos) : 0;
                const stepSize = computeNiceStep(maxVal);
                const suggestedMax = Math.ceil(maxVal / stepSize) * stepSize;

                // plugin para desenhar rótulos de valor nas barras
                const valueLabelPlugin2 = {
                    id: 'valueLabelPlugin2',
                    afterDatasetsDraw: (chart, args, options) => {
                        const ctx = chart.ctx;
                        chart.data.datasets.forEach((dataset, dsIndex) => {
                            const meta = chart.getDatasetMeta(dsIndex);
                            meta.data.forEach((element, index) => {
                                const value = dataset.data[index] ?? 0;
                                const formatted = Number(value).toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Kz';
                                const position = element.tooltipPosition();
                                ctx.save();
                                ctx.fillStyle = (options && options.color) ? options.color : '#0b1220';
                                ctx.font = (options && options.font) ? options.font : '12px "Segoe UI", Arial';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                if (chart.options && chart.options.indexAxis === 'y') {
                                    ctx.textAlign = 'left';
                                    ctx.fillText(formatted, position.x + 8, position.y);
                                } else {
                                    ctx.textBaseline = 'bottom';
                                    ctx.fillText(formatted, position.x, position.y - 6);
                                }
                                ctx.restore();
                            });
                        });
                    }
                };

                mesCorrenteChartInstance = new Chart(canvasMes.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total por Natureza (Kz)',
                            data: valoresNumericos,
                            backgroundColor: '#4facfe',
                            borderRadius: 10,
                            barThickness: 38,
                            hoverBackgroundColor: '#1877F2'
                        }]
                    },
                    plugins: [valueLabelPlugin2],
                    options: {
                        indexAxis: 'x',
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.parsed.y || 0;
                                        return ' ' + value.toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' Kz';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: { color: '#eef2f7' },
                                ticks: { color: '#4b5563', font: { size: 12 } }
                            },
                            y: {
                                beginAtZero: true,
                                suggestedMax: suggestedMax,
                                grid: { color: '#f3f5fb' },
                                ticks: {
                                    color: '#4b5563',
                                    font: { size: 12 },
                                    stepSize: stepSize,
                                    callback: function(value) {
                                        try {
                                            return Number(value).toLocaleString('pt-PT', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                        } catch (e) {
                                            return value;
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (err) {
                console.error('Erro ao criar gráfico de despesas:', err);
                ctx.save();
                ctx.font = '16px "Segoe UI", Arial';
                ctx.fillStyle = '#e65c1a';
                ctx.textAlign = 'center';
                ctx.fillText('Erro ao desenhar o gráfico de despesas.', canvasMes.width / 2, canvasMes.height / 2);
                ctx.restore();
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const mesCorrenteLabels = @json($mesCorrenteLabels);
            const mesCorrenteValores = @json($mesCorrenteValores);
            renderGraficoMesCorrente(mesCorrenteLabels, mesCorrenteValores);
        });

        window.addEventListener('atualizar-grafico-mes-corrente', function(event) {
            const detail = event.detail || {};
            const labels = detail.labels || [];
            const valores = detail.valores || [];
            renderGraficoMesCorrente(labels, valores);
        });
    </script>

    <script>
        function baixarGraficoMesCorrente() {
            const canvas = document.getElementById('graficoMesCorrente');
            if (!canvas) return;
            const tmpCanvas = document.createElement('canvas');
            tmpCanvas.width = canvas.width;
            tmpCanvas.height = canvas.height;
            const ctx = tmpCanvas.getContext('2d');
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, tmpCanvas.width, tmpCanvas.height);
            ctx.drawImage(canvas, 0, 0);
            const link = document.createElement('a');
            link.href = tmpCanvas.toDataURL('image/png');
            link.download = 'grafico_despesas_mes_corrente.png';
            link.click();
        }
    </script>
</div>