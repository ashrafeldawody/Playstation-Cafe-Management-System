@extends('adminlte::page')

@section('title', 'المخزون')

@section('content_header')
    <h1>المخزون</h1>
@stop

@section('content')
    {{ $dataTable->table() }}
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
