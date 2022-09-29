@extends('adminlte::page')

@section('title', 'الكافيه')

@section('content_header')

@stop

@section('content')
    <cafe-cart :items="{{$items}}"></cafe-cart>
@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop
