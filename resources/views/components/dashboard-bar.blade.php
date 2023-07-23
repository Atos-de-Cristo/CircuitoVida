<div class="w-80  rounded-lg p-4 flex-1">
    <div>
        <canvas id="myChart" class="dark:bg-slate-700 bg-white rounded-xl p-5"></canvas>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

     const cores = [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ];

       
        const coresDinamicas = [];
        for (let i = 0; i < 10; i++) {
            const corIndex = i % cores.length;
            coresDinamicas.push(cores[corIndex]);
        }
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Cultura', 'Integração', 'Imersão', 'Liderança', 'Purple', 'Orange'],
                datasets: [{
                    label: 'Alunos por curso',
                    data: [12, 19, 3, 5, 2, 3],
                    borderWidth: 1,
                    backgroundColor: coresDinamicas,
                    borderColor: coresDinamicas,
                    borderWidth: 1
                }]
            },
            options: {
                
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    @endpush

</div>
