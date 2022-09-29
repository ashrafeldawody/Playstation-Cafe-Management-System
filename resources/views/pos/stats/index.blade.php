@extends('adminlte::page')

@section('title', 'الرئيسية')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>احصائيات الشيفت</h1>
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
        {{ $dataTable->table() }}
    </div>
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
