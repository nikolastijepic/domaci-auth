@extends('layout')

@section('pageTitle')
    Forecast - {{ $city->name }}
@endsection


@section('pageContent')

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Forecast for {{ $city->name }}</h4>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>Sunrise</th>
                        <th>Sunset</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $sunrise }}</td>
                            <td>{{ $sunset }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
