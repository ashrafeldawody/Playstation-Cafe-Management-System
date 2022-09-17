@extends('adminlte::page')

@section('title', 'الأجهزة')

@section('content_header')
    <h1>الأجهزة</h1>
@stop

@section('content')
    {{$dataTable->table()}}
@stop

@section('css')

@stop

@section('js')
    {{$dataTable->scripts()}}
    <script>
        $('#myTable').DataTable();
    </script>
@stop
