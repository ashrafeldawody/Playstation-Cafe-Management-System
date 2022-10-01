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
    <div class="w-100">
        {{$dataTable->table([
            'class' => 'table table-striped table-bordered table-hover w-100'
        ])}}
    </div>
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}

@stop
