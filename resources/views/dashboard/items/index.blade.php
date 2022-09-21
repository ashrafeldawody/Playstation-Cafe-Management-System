@extends('adminlte::page')

@section('title', 'الأجهزة')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>المنتجات</h1>
        <a href="{{ route('items.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            اضافة منتج جديد
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
