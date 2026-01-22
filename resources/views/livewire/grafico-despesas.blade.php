<div>
    <h4>Gráfico de Despesas por Natureza</h4>
    <button class="btn btn-danger mb-2" id="exportarPdfGrafico">Exportar PDF</button>
    <canvas id="graficoDespesas" height="120"></canvas>
    <div id="graficoPlaceholder" style="text-align:center; color:#888; margin-top:10px; display:none;">Nenhum dado para exibir.</div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    let graficoDespesasChart;
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('graficoDespesas').getContext('2d');
        graficoDespesasChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Exemplo'],
                datasets: [{
                    label: 'Total por Natureza',
                    data: [0],
                    backgroundColor: 'rgba(200,200,200,0.3)',
                    borderColor: 'rgba(200,200,200,0.6)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: { display: true },
                    title: { display: false }
                },
                scales: {
                    x: { title: { display: true, text: 'Natureza' } },
                    y: { beginAtZero: true, title: { display: true, text: 'Valor' } }
                }
            }
        });

        // Carrega dados e atualiza gráfico
        fetch('/api/relatorios/despesas-por-natureza')
            .then(response => response.json())
            .then(data => {
                // Garante que labels sejam sempre naturezas (strings), nunca datas
                let labels = Array.isArray(data.labels) ? data.labels.map(String) : [];
                let valores = Array.isArray(data.valores) ? data.valores.map(Number) : [];
                if (!labels.length) {
                    document.getElementById('graficoPlaceholder').style.display = 'block';
                    graficoDespesasChart.data.labels = ['Exemplo'];
                    graficoDespesasChart.data.datasets[0].data = [0];
                } else {
                    document.getElementById('graficoPlaceholder').style.display = 'none';
                    graficoDespesasChart.data.labels = labels;
                    graficoDespesasChart.data.datasets[0].data = valores;
                }
                graficoDespesasChart.update();
            });

        document.getElementById('exportarPdfGrafico').addEventListener('click', function () {
            html2canvas(document.getElementById('graficoDespesas')).then(function(canvas) {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF();
                pdf.addImage(imgData, 'PNG', 10, 10, 180, 90);
                pdf.save('grafico-despesas.pdf');
            });
        });
    });
</script>
@endpush
