@extends('adminlte::page')

@section('title', 'انواع الأجهزة')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>انواع الأجهزه</h1>
        <a href="{{ route('device-categories.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            اضافة نوع جديد
        </a>
    </div>
@stop

@section('content')
    @include('includes.errors')
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
