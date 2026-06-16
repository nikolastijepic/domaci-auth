@extends('admin-layout')

@section('pageTitle')
    Add Weather - Admin
@endsection


@section('pageContent')

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form method="POST" action="{{ route('admin.weather.update', ['weather' => $weather->id]) }}">
                    @csrf

                    <div>
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">City</label>
                        <input type="text"
                               name="city"
                               class="form-control"
                               id="city"
                               placeholder="Enter city name"
                               value="{{ $weather->city }}">
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Temperature</label>
                        <input type="number"
                               name="temperature"
                               class="form-control"
                               id="temperature"
                               placeholder="Enter temperature in °C"
                               value="{{ $weather->temperature }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>

@endsection
