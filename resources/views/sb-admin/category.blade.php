@extends('layouts.sb-admin.app')

@section('content')
    <style>
        #google-chart {
            width: 100%;
            height: auto;
            margin: 0 auto;
        }

        .g-chart {
            overflow: scroll;
        }
    </style>
    <div id="layoutSidenav">
        @include('layouts.sb-admin.side')
        <div id="layoutSidenav_content">
            <main>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Tree Map Chart
                            </div>
                            <div class="card-body g-chart">
                                <div id="treemap-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Bar Chart
                    </div>
                    <div class="card-body">
                        <div id="bar-chart" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </main>
            @include('layouts.sb-admin.footer')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{url('/js/sb-admin/class-watcher.js')}}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    @isset($google_chart)
        @include('components.treemap-chart',['treemap'=>$google_chart['treemap']])
        @include('components.bar-chart',['bar'=>$google_chart['bar']])
    @endisset
    @include('components.script-zone')
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>--}}
    {{--    <script src="assets/demo/chart-area-demo.js"></script>--}}
    {{--    <script src="assets/demo/chart-bar-demo.js"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>--}}
{{--    <script src="js/datatables-simple-demo.js"></script>--}}
@endsection
