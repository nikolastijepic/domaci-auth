@php use App\Http\Helpers\ForecastHelper; @endphp
@extends('layout')

@section('pageTitle')

@endsection


@section('pageContent')
    <div class="container mt-4">
        <div class="mb-3">
            <h4 class="mb-1">Search Results</h4>
            <p class="text-body-secondary mb-0">
                {{ $cities->count() }} cities found
            </p>
        </div>

        <div class="row g-3">
            @foreach($cities as $city)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <a href="{{ route('city.forecasts', $city) }}"
                       class="card text-decoration-none h-100 shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <i class="fa-solid {{ ForecastHelper::weatherIcon($city->todayForecast->weather_type) }} fs-4 text-primary me-3"></i>
                            <div class="flex-grow-1">
                                <h6 class="card-title mb-0">
                                    {{ $city->name }}
                                </h6>
                            </div>
                            <i class="bi bi-chevron-right text-secondary"></i>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
