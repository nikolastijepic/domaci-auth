@extends('admin.layout')

@section('pageTitle')
    Add Forecast - Admin
@endsection


@section('pageContent')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="POST" action="{{ route('admin.forecast.add') }}">
                    @csrf

                    <div>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="city_id" class="form-label">City</label>
                        <select name="city_id" id="city_id" class="form-control">
                            <option value="">Select a city</option>

                            @foreach($cities as $city)
                                <option value="{{ $city->id }}"
                                    @selected(old('city_id') == $city->id)>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date"
                               name="date"
                               class="form-control"
                               id="date"
                               value="{{ old('date', now()->addDay()->format('Y-m-d')) }}"
                               min="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label for="temperature" class="form-label">Temperature</label>
                        <input type="number"
                               name="temperature"
                               class="form-control"
                               id="temperature"
                               placeholder="Enter temperature in °C"
                               value="{{ old('temperature') }}">
                    </div>

                    <div class="mb-3">
                        <label for="weather_type" class="form-label">Weather Type</label>
                        <select name="weather_type" id="weather_type" class="form-control">
                            <option value="">Select weather type</option>

                            <option value="sunny" @selected(old('weather_type') == 'sunny')>
                                Sunny
                            </option>

                            <option value="rainy" @selected(old('weather_type') == 'rainy')>
                                Rainy
                            </option>

                            <option value="snowy" @selected(old('weather_type') == 'snowy')>
                                Snowy
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="probability" class="form-label">
                            Precipitation Probability (%)
                        </label>

                        <input type="number"
                               name="probability"
                               class="form-control"
                               id="probability"
                               min="0"
                               max="100"
                               placeholder="Required for rainy and snowy forecasts"
                               value="{{ old('probability') }}">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Add Forecast
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
