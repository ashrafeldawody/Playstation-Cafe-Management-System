@extends('adminlte::page')

@section('title', 'الرئيسية')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>الرئيسية</h1>
        <div>
            <form action="{{ route('dashboard') }}" method="get" class="row">
                <input type="date" class="form-control col-5" name="start_time" value="{{old('start_time', request()->start_time) }}">
                <input type="date" class="form-control col-5" name="end_time" value="{{old('end_time', request()->end_time) }}">
                <button type="submit" class="btn btn-primary  col-2">بحث</button>
            </form>
        </div>
    </div>
@stop

@section('content')
    @if($errors->any())
            <ul class="list-group my-3">
                @foreach($errors->all() as $error)
                    <li class="list-group-item">{{ $error }}</li>
                @endforeach
            </ul>
    @endif

    <div class="row">
        @foreach($stats as $stat)
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box {{$stat['bg-color']}}">
                <div class="inner">
                    <h3>{{ $stat['value'] }}</h3>

                    <p>{{ $stat['title'] }}</p>
                </div>
                <div class="icon">
                    <i class="{{ $stat['icon'] }}"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">المنتجات الأكثر مبيعاً</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>المنتج</th>
                            <th>عدد المبيعات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($topSelling as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->item->name }}</td>
                                <td>{{ $product->total }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">الأجهزة الاكثر تشغيلا</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>الجهاز</th>
                            <th>مرات التشغيل</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($mostActiveDevice as $device)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $device->device->name }}</td>
                                <td>{{ $device->total }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')
@stop
