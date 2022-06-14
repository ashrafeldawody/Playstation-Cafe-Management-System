@extends('cashier.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>الأجهزة</h3>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @dd($devices);
                            @foreach($devices as $device)
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5 class="card-title">{{ $device->name }}</h5>
                                            <img src="/images/ps4.png" style="height: 2rem;width: auto" alt="...">
                                        </div>
                                        <div class="card-body text-center">
                                            <h1 class="card-text">00:00:00</h1>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
