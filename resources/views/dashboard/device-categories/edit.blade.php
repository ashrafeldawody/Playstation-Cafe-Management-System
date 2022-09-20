@extends('adminlte::page')

@section('title', 'انواع الأجهزة')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">{{ $deviceCategory->name }}
            -
            تعديل البيانات</h3>
        </div>
        <form action="{{ route('device-categories.update', $deviceCategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required value="{{ $deviceCategory->name }}">
                </div>
                <div class="form-group">
                    <label for="price">سعر الساعة</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="سعر الساعة" required value="{{ $deviceCategory->price }}">
                </div>
                <div class="form-group">
                    <label for="multi_price">سعر المالتي</label>
                    <input type="number" class="form-control" id="multi_price" name="multi_price" placeholder="سعر المالتي"  value="{{ $deviceCategory->multi_price }}">
                </div>
                <div class="form-group">
                    <label for="discount">نسبه الخصم</label>
                    <input type="number" class="form-control" id="discount" name="discount" placeholder="نسبه الخصم"  value="{{ $deviceCategory->discount }}">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </form>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
