@extends('admin.layout')

@section('pageTitle')
    Weather - Admin
@endsection


@section('pageContent')

    <div class="container mt-5">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Weather Forecast</h4>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>City</th>
                        <th>Temperature</th>
                        <th class="text-center" style="width: 180px;">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($weathers as $weather)
                        <tr
                            @if(session('new_weather_id') === $weather->id)
                                class="table-success"
                            @elseif(session('updated_weather_id') === $weather->id)
                                class="table-warning"
                            @endif
                        >
                            <td>{{ $weather->city->name }}</td>
                            <td>
                            <span class="badge bg-primary">
                                {{ $weather->temperature }} °C
                            </span>
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.weather.edit', ['weather' => $weather->id]) }}"
                                       class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('admin.weather.delete', ['weather' => $weather->id]) }}"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to delete this weather record?')"
                                    >Delete</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
