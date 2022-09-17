@extends('adminlte::page')

@section('title', 'الاعدادات')

@section('content_header')
    <h1>الاعدادات</h1>
@stop

@section('content')
    {{ $dataTable->table() }}
@stop

@section('css')

@stop

@section('js')
{{ $dataTable->scripts() }}
@stop
