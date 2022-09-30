@extends('adminlte::page')

@section('title', 'الرئيسية')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>الورديات</h1>
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
    @if(isset($stats))
    <div class="d-flex justify-content-around">
        @foreach($stats as $stat)
        <div class="w-25">
            <!-- small box -->
            <div class="small-box {{$stat['bg-color']}}">
                <div class="inner">
                    <h3>{{ $stat['value'] }} </h3>
                    <p>{{ $stat['title'] }}</p>
                </div>
                <div class="icon">
                    <i class="{{ $stat['icon'] }}"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
    <div class="w-100">
        {{ $dataTable->table() }}
    </div>
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
