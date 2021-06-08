<script src="{{url('/js/sb-admin/google-bar-chart.js')}}?{{time()}}"></script>
<script>
    var chart = "{{ $bar['chart'] ?? '' }}";
    var elementId = "{{ $bar['element'] ?? '' }}";
    var data = @json($bar['data'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    var columns = @json($bar['columns'] ?? [],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    var options = @json($bar['options'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


    google.charts.load('current', {packages: ['{{ $bar['packages'] ?? 'treemap' }}']});

    if (chart === "bar") {
        google.charts.setOnLoadCallback(function () {
            drawChart(elementId, data, options, columns);
        });
    } else if (chart === "treemap") {
        google.charts.setOnLoadCallback(function () {
            drawChart(elementId, data, options);
        });
    } else {
        google.charts.setOnLoadCallback(function () {
            drawChart();
        });
    }

    $(window).resize(function () {
        drawChart();
    });

    let target = document.body;

    let classWatcher = new ClassWatcher(target, 'sb-sidenav-toggled', drawChart, drawChart);
</script>
