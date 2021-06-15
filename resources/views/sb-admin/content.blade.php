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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>
                                    Tree Map Chart Example
                                </div>
                                <div class="card-body g-chart">
                                    <div id="google-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            DataTable Example
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </main>
            @include('layouts.sb-admin.footer')
        </div>
    </div>
    @isset($google_chart)
        @include('components.treemap-chart',['treemap'=>$google_chart['treemap']])
        @include('components.bar-chart',['bar'=>$google_chart['bar']])
    @endisset
    @include('components.script-zone')
@endsection
