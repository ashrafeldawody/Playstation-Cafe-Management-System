@extends('adminlte::page')

@section('title', 'انواع المنتجات')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>انواع المنتجات</h1>
        <a href="{{ route('item-categories.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            اضافة نوع جديد
        </a>
    </div>

@stop

@section('content')
    @include('includes.errors')
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
