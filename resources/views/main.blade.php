@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Example</div>
                <div class="card-body">
                    <h3>섹터: 전기전자</h3>
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
                                        <tr>
                                            <td>{{ $item->get('code') }}</td>
                                            <td>{{ $item->get('name') }}</td>
                                            <td>{{ $item->get('current_price') }}</td>
                                            <td>{{ $item->get('flow_rate_avg') }}</td>
                                            <td>{{ $item->get('debt_rate_avg') }}</td>
                                        </tr>
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
