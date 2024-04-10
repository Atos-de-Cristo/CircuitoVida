<div
    x-data="{ labels: @entangle($labels), data: @entangle($data) }"
    x-init="new Chart($refs.myChart, {
        type: '{{$type}}',
        data: {
            labels,
            datasets: [{
                label: '{{$title}}',
                data: data,
                borderWidth: 1,
                backgroundColor: [
                    'rgb(255, 99, 132 )',
                    'rgb(54, 162, 235)',
                    'rgb(255, 206, 86)',
                    'rgb(75, 192, 192)',
                ],
                hoverOffset: 4
            }],
        },
        options: {

            scales: {

                y: {
                    beginAtZero: true
                }
            }
        }
    });"
>

        <canvas id="myChart" width="400" height="200" x-ref="myChart"></canvas>

</div>


@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

@endpush
