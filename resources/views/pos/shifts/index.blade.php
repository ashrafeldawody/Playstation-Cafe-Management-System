@extends('adminlte::page')

@section('title', 'الرئيسية')

@section('content_header')

@stop

@section('content')
        <h1 class="alert alert-info text-center mt-5 py-5">
            لم يتم بدء الشيفت بعد!
        </h1>
        <form action="{{ route('pos.shift.start') }}" method="POST" class="text-center">
            @csrf
            <button type="submit" class="btn btn-primary">
                بدء الشيفت
            </button>
        </form>

@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop
