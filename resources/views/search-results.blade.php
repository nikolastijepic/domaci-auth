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

        <div>
            @if(session('error'))
                <div class="alert alert-warning text-center">
                    <p class="mb-3">{{ session('error') }}</p>

                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Log in
                    </a>
                </div>
            @endif
        </div>

        <div>
            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <div class="row g-3 align-items-stretch">
            @foreach($cities as $city)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="d-flex align-items-center">

                        @if(in_array($city->id, $userFavorites))
                            <a href="{{ Route('user.city.favorite.delete', ['city' => $city->id]) }}" class="btn btn-link p-0 me-2">
                                <i class="fa-solid fa-star text-warning"></i>
                            </a>
                        @else
                            <a href="{{ Route('user.city.favorite.add', ['city' => $city->id]) }}" class="btn btn-link p-0 me-2">
                                <i class="fa-regular fa-star text-warning"></i>
                            </a>
                        @endif

                        <a href="{{ route('city.forecast', $city) }}"
                           class="card text-decoration-none h-100 w-100 shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <i class="fa-solid {{ ForecastHelper::weatherIcon($city->todayForecast->weather_type) }} fs-4 text-primary me-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-0">
                                        {{ $city->name }}
                                    </h6>
                                </div>
                                <i class="bi bi-chevron-right text-secondary ms-3"></i>
                            </div>
                        </a>
                    </div>


                </div>
            @endforeach
        </div>
    </div>

@endsection
