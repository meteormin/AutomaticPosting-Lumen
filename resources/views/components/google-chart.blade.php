<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="{{url('/js/sb-admin/class-watcher.js')}}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@isset($chart)
    <script src="{{url('/js/sb-admin/google-'. $chart .'-chart.js')}}?{{time()}}"></script>
@else
    <script src="{{url('/js/sb-admin/google-example-chart.js')}}"></script>
@endisset

<script>
    var chart = "{{ $chart ?? '' }}";
    var elementId = "{{ $element ?? '' }}";
    var data = @json($data ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    var columns = @json($columns ?? [],JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    var options = @json($options ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);


    google.charts.load('current', {packages: ['{{ $packages ?? 'treemap' }}']});

    if (chart === "bar") {
        google.charts.setOnLoadCallback(function () {
            drawBarChart(elementId, data, options, columns);
        });
    } else if (chart === "treemap") {
        google.charts.setOnLoadCallback(function () {
            drawTreeMapChart(elementId, data, options);
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
