<script src="{{url('/js/sb-admin/google-bar-chart.js')}}?{{time()}}"></script>
<script>
    let barChart = "{{ $bar['chart'] ?? '' }}";
    let barChartId = "{{ $bar['element'] ?? '' }}";
    let barChartData = @json($bar['data'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    let barChartColumns = @json($bar['columns'] ?? [],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    let barChartOptions = @json($bar['options'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    google.charts.load('current', {packages: ['{{ $bar['packages'] ?? 'corechart' }}']});

    google.charts.setOnLoadCallback(function () {
        drawBarChart(barChartId, barChartData, barChartOptions, barChartColumns);
    });

    $(window).resize(function () {
        drawBarChart(barChartId, barChartData, barChartOptions, barChartColumns);
    });

    target = document.body;

    barChartclassWatcher = new ClassWatcher(target, 'sb-sidenav-toggled', drawBarChart, drawBarChart);
</script>
