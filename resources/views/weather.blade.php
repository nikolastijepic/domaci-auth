@extends('layout')

@section('pageTitle')
    Weather
@endsection


@section('pageContent')

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Weather</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>City (click for forecasts)</th>
                        <th>Temperature</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($weathers as $weather)
                        <tr>
                            <td>
                                <a href="{{ route('city.forecasts', $weather->city) }}">{{ $weather->city->name }} </a>
                            </td>
                            <td>{{ $weather->temperature }} °C</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
