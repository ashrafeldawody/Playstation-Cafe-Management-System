@extends('adminlte::page')

@section('title', 'الاعدادات')

@section('content_header')
    <h1>الاعدادات</h1>
@stop

@section('content')
    <div class="w-100">
        {{$dataTable->table([
            'class' => 'table table-striped table-bordered table-hover w-100'
        ])}}
    </div>
@stop

@section('css')

@stop

@section('js')
{{ $dataTable->scripts() }}
@stop
