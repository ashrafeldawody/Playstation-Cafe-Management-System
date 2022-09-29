@extends('adminlte::page')

@section('title', 'الرئيسية')

@section('content_header')
    <devices-page :devices="{{ $devices }}" :user="{{auth()->user()}}" :items="{{$items}}"></devices-page>
@stop

@section('content')

@stop

@section('css')

@stop


