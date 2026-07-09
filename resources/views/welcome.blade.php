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

        </div>
    </div>

@endsection
