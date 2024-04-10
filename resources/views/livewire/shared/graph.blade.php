
<div>
    <canvas id="myChart" width="400" height="200"></canvas>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script>
        Livewire.on('chartUpdated', (chart) => {
            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: chart.type,
                data: {
                    labels: chart.labels,
                    datasets: chart.datasets, // Optional for complex charts
                },
                options: chart.options, // Optional for customizations
            });
        });
    </script>
@endpush
