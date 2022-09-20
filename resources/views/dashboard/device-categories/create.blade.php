@extends('adminlte::page')

@section('title', 'انواع الأجهزة')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">اضافة نوع جديد</h3>
        </div>
        <form action="{{ route('device-categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required>
                </div>
                <div class="form-group">
                    <label for="price">سعر الساعة</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="سعر الساعة" required>
                </div>
                <div class="form-group">
                    <label for="multi_price">سعر المالتي</label>
                    <input type="number" class="form-control" id="multi_price" name="multi_price" placeholder="سعر المالتي">
                </div>
                <div class="form-group">
                    <label for="discount">نسبه الخصم</label>
                    <input type="number" class="form-control" id="discount" name="discount" placeholder="نسبه الخصم">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
