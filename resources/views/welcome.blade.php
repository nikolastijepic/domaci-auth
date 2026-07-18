@php use App\Http\Helpers\ForecastHelper; @endphp
@extends('layout')

@section('pageTitle')

@endsection


@section('pageContent')

    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6 col-xl-5">

            <h1 class="text-center mb-4">Weather Search</h1>
            <p class="text-center text-body-secondary mb-4">
                Enter a city name to view the current weather and forecast.
            </p>

            @if(session('error'))
                <div class="alert alert-warning text-center">
                    No cities found matching "<strong>{{ old('city') }}</strong>".
                </div>
            @endif

            <form action="{{ route('search.results') }}" method="GET">
                <div class="input-group input-group-lg">
                    <input
                        type="text"
                        class="form-control"
                        name="city"
                        placeholder="Enter city name..."
                        aria-label="City name"
                        required
                    >

                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                </div>
            </form>

            @if($favorites->isNotEmpty())
                <h3 class="mt-5 mb-4 text-center">
                    <i class="fa-solid fa-star text-warning"></i>
                    Favorite Cities
                </h3>

            <div class="d-flex flex-column gap-3">
                @foreach($favorites as $favorite)
                    <a class="card text-decoration-none h-100 w-100 shadow-sm">
                        <div class="card-body d-flex justify-content-center align-items-center gap-3">

                            <i class="fa-solid {{ ForecastHelper::weatherIcon($favorite->city->todayForecast->weather_type) }} fs-4 text-primary me-3"></i>

                            <div class="{{ ForecastHelper::temperatureColor($favorite->city->todayForecast->temperature) }} fw-bold fs-3 me-4">
                                {{ $favorite->city->todayForecast->temperature }}°
                            </div>

                            <div class="flex-grow-1">
                                <h6 class="card-title fw-bold fs-4 mb-0">
                                    {{ $favorite->city->name }}
                                </h6>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            @endif

        </div>
    </div>

@endsection
