@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Example</div>
                <div class="card-body">
                    <h3>섹터: 전기전자(2017 ~ 2020)</h3>
                        @if(isset($data))
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">업종</th>
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
                        @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
