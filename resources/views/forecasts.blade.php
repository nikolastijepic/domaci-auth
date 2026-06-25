@extends('layout')

@section('pageTitle')
    Forecasts
@endsection


@section('pageContent')

    <div class="container mt-5">
        <h2 class="mb-4">Forecasts</h2>

        @foreach($groupedForecasts as $cityForecasts)

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        {{ $cityForecasts->first()->city->name }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Temperature</th>
                            <th>Weather type</th>
                            <th>Probability</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($cityForecasts as $forecast)
                            <tr>
                                <td>{{ $forecast->date }}</td>
                                <td class="{{ $forecast->temperature_class }}">
                                    {{ $forecast->temperature }} °C
                                </td>
                                <td>{{ $forecast->weather_type }}</td>
                                <td>{{ $forecast->probability }}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>

        @endforeach

    </div>

@endsection
