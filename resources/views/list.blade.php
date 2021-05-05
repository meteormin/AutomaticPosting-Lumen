@extends('layouts.app')
@section('header')
    @include('layouts.header')
@endsection

@section('content')
    <!-- Main Content-->
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @isset($posts)
                    @if(count($posts->getData()) == 0)
                        @include('components.post-preview-404')
                    @else
                        @foreach($posts->getData() as $post)
                            @include('components.post-preview',[
                                'url'=>url("/posts/{$post->getId()}"),
                                'title'=>$post->getTitle(),
                                'subtitle'=>$post->getSubTitle(),
                                'created_by'=>$post->getCreatedBy(),
                                'created_at'=>$post->getCreatedAt()
                                ])
                        @endforeach
                    @endif
                @else
                    @include('components.post-preview-404')
                @endisset
                <!-- Pager-->
                <div class="clearfix"><a class="btn btn-primary float-right" href="{{ $posts->getNextPageUrl() ?? '#' }}">Older Posts →</a></div>
            </div>
        </div>
    </div>
    <hr />
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
