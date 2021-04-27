@extends('layouts.app')
@include('layouts.list-header')

@section('content')
<!-- Main Content-->
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
            @foreach($list as $post)
                @include('components.post-preview',['url'=>'localhost','title'=>'finance','subtitle'=>'with lumen','created_by'=>'miniyu97@gmail.com','created_at'=>\Carbon\Carbon::now()])
            @endforeach
            <!-- Pager-->
            <div class="clearfix"><a class="btn btn-primary float-right" href="#!">Older Posts →</a></div>
        </div>
    </div>
</div>
<hr />
@endsection
