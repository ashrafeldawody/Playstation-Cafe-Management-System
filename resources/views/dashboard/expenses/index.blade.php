@extends('adminlte::page')

@section('title', 'التقارير')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>المصاريف</h1>
        <a href="{{ route('expenses.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            اضافة مصروفات
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
