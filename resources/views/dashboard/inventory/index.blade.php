@extends('adminlte::page')

@section('title', 'المخزون')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>المخزون</h1>
        <a href="{{ route('inventory.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            اضافة للمخزون
        </a>
    </div>
@stop

@section('content')
    {{ $dataTable->table() }}
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
