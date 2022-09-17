@extends('adminlte::page')

@section('title', 'التقارير')

@section('content_header')
    <h1>المصروفات</h1>
@stop

@section('content')
    {{ $dataTable->table() }}
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
