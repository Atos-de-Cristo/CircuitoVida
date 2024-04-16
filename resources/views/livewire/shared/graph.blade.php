<div>
    <canvas id="myChart_{{$code}}" width="400" height="200"></canvas>
</div>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script>
        document.addEventListener('livewire:load', function () {
            var ctx = document.getElementById('myChart_{{$code}}').getContext('2d');
            var myChart = new Chart(ctx, {
                type: '{{ $type }}',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: '{{ $title }}',
                        data: {!! json_encode($values) !!},
                        borderWidth: 1,
                        backgroundColor: [
                            'rgb(255, 99, 132 )',
                            'rgb(54, 162, 235)',
                            'rgb(255, 206, 86)',
                            'rgb(75, 192, 192)',
                        ],
                        hoverOffset: 4
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
        });
    </script>
@endpush
