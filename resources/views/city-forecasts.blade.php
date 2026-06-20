@extends('layout')

@section('pageTitle')
    Forecasts - {{ $city->name }}
@endsection


@section('pageContent')

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Forecasts for {{ $city->name }}</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Temperature</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forecasts as $forecast)
                        <tr>
                            <td>{{ $forecast->date }}</td>
                            <td>{{ $forecast->temperature }} °C</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
