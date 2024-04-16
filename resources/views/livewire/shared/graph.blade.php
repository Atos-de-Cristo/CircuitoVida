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
                            // Original Colors
                            'rgb(255, 99, 132)', // Red
                            'rgb(54, 162, 235)', // Blue
                            'rgb(255, 206, 86)', // Yellow
                            'rgb(75, 192, 192)', // Teal

                            // Complementary Variations
                            'rgb(153, 255, 153)', // Light Green
                            'rgb(0, 64, 0)', // Dark Green
                            'rgb(0, 128, 128)', // Teal

                            'rgb(255, 192, 128)', // Light Orange
                            'rgb(128, 32, 0)', // Dark Orange
                            'rgb(255, 128, 0)', // Orange

                            'rgb(255, 128, 255)', // Light Purple
                            'rgb(64, 0, 64)', // Dark Purple
                            'rgb(128, 0, 128)', // Purple

                            'rgb(255, 165, 0)', // Dark Red-Orange
                            'rgb(255, 69, 0)', // Dark Orange

                            // Analogous Variations
                            'rgb(229, 57, 53)', // Red-Orange
                            'rgb(255, 140, 0)', // Deep Orange
                            'rgb(255, 185, 15)', // Gold

                            'rgb(0, 130, 177)', // Turquoise
                            'rgb(32, 178, 216)', // Light Sky Blue
                            'rgb(0, 122, 195)', // Sky Blue

                            // Triadic Variations
                            'rgb(255, 0, 0)', // Magenta
                            'rgb(0, 0, 255)', // Navy
                            'rgb(0, 255, 0)', // Lime Green

                            // Additional Variations
                            'rgb(255, 152, 150)', // Pink
                            'rgb(205, 92, 0)', // Burnt Sienna
                            'rgb(102, 187, 89)', // Mint Green
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
