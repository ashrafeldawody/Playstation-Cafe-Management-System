@extends('adminlte::page')

@section('title', 'انواع المنتجات')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">اضافة نوع</h3>
        </div>
        <form action="{{ route('item-categories.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required>
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
