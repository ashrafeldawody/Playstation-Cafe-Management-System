@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>{{$title}}</h1>
        @if(isset($button))
        <a href="{{ $button['route'] }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            {{$button['title']}}
        </a>
        @endif
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
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
    @endif

    @if(isset($stats))
    <div class="d-flex flex-wrap justify-content-around">
        @foreach($stats as $stat)
        <div class="mx-3" style="width:300px">
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
    @endif
    <div class="w-100">
        {{ $dataTable->table(['class' => 'w-100 table table-striped table-bordered table-hover']) }}
    </div>
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
