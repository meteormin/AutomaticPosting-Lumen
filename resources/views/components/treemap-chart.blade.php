<script src="{{url('/js/sb-admin/google-treemap-chart.js')}}?{{time()}}"></script>
<script>
    let treeMapChart = "{{ $treemap['chart'] ?? '' }}";
    let treeMapId = "{{ $treemap['element'] ?? '' }}";
    let treeMapData = @json($treemap['data'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    let treeMapOptions = @json($treemap['options'] ?? [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    google.charts.load('current', {packages: ['{{ $treemap['packages'] ?? 'treemap' }}']});

    google.charts.setOnLoadCallback(function () {
        drawTreeMapChart(treeMapId, treeMapData, treeMapOptions);
    });
    $(window).resize(function () {
        drawTreeMapChart(treeMapId, treeMapData, treeMapOptions);
    });

    target = document.body;

    treeMapClassWatcher = new ClassWatcher(target, 'sb-sidenav-toggled', drawChart, drawChart);
</script>
