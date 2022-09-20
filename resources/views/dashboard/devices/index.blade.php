@extends('adminlte::page')

@section('title', 'الأجهزة')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>الأجهزة</h1>
        <a href="{{ route('devices.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            اضافة جهاز جديد
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
@stop
