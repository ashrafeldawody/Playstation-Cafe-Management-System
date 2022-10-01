@extends('adminlte::page')

@section('title', 'الفواتير')

@section('content_header')
    <h1>الفواتير</h1>
@stop

@section('content')
    {{$dataTable->table([
        'class' => 'table table-striped table-bordered table-hover w-100'
    ])}}
@stop

@section('css')

@stop

@section('js')
    {{ $dataTable->scripts() }}
@stop
