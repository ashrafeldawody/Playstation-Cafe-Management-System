@extends('adminlte::page')

@section('title', 'الأجهزة')

@section('content_header')
    <h1>الأجهزة</h1>
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
    <script>
        $('#myTable').DataTable();
    </script>
@stop
