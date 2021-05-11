<!-- Page Header-->
{{-- <header class="masthead" style="background-image: url('{{ url('/assets/img/post-bg.jpg') }}')"> --}}
<header class="masthead">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="post-heading">
                    <h1>{{ $title }}</h1>
                    <h2 class="subheading">{{ $subtitle }}</h2>
                    <span class="meta">
                        Posted by
                        <a href="#!">{{ $created_by }}</a><br>
                        <br>
                        {{ $created_at }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>
