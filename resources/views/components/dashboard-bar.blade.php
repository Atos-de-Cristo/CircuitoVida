<div class="w-80  rounded-lg p-4 flex-1">
    <div id="chart" class="bg-white dark:bg-slate-800 p-5">
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>

var options = {
  chart: {
    type: 'bar'
  },
  series: [{
    name: 'sales',
    data: [30,40,45,50,49,60,70,91,125]
  }],
  xaxis: {
    categories: [1991,1992,1993,1994,1995,1996,1997, 1998,1999]
  }
}

var chart = new ApexCharts(document.querySelector("#chart"), options);

chart.render();
    </script>
    @endpush

</div>
