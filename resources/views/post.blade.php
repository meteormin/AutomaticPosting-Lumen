@extends('layouts.app')
@section('header')
    @include('layouts.post-header',[
        'title'=>$post->getTitle(),
        'subtitle'=>$post->getSubTitle(),
        'created_by'=>$post->getCreatedBy(),
        'created_at'=>$post->getCreatedAt()
    ])
@endsection

@section('content')
<!-- Post Content-->
<article>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                @isset($post)
                    {!! html_entity_decode($post->getContents()) !!}
                @endisset
                {{-- <h3>{{ $title }}: {{ $name }}({{ $date }})</h3>
                        @if(isset($data))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">종목코드</th>
                                            <th scope="col">이름</th>
                                            <th scope="col">현재가</th>
                                            <th scope="col">적자횟수</th>
                                            <th scope="col">유동비율</th>
                                            <th scope="col">부채비율</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $item)
                                            @if($item instanceof \App\DataTransferObjects\Refine)
                                                <tr>
                                                    <td>{{ $item->getCode() }}</td>
                                                    <td>{{ $item->getName() }}</td>
                                                    <td>{{ $item->getCurrentPrice() }}</td>
                                                    <td>{{ $item->getDeficitCount() }}</td>
                                                    <td>{{ $item->getFlowRateAvg() }}</td>
                                                    <td>{{ $item->getDebtRateAvg() }}</td>
                                                </tr>
                                            @endif
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @else
                            데이터가 없습니다.
                        @endif --}}
            </div>
        </div>
    </div>
</article>
<hr />
@endsection

@section('footer')
    @include('layouts.footer')
@endsection
