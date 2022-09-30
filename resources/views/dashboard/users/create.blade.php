@extends('adminlte::page')

@section('title', 'اضافة موظف')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">اضافة موظف جديد</h3>
        </div>
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('includes.errors')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required>
                </div>
                <div class="form-group">
                    <label for="email">الايميل</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="الايميل" required>
                </div>

                <div class="form-group">
                    <label for="phone">رقم الموبايل</label>
                    <input type="number" class="form-control" id="phone" name="phone" placeholder="رقم الموبايل" required>
                </div>

                <div class="form-group">
                    <label for="national_id">الرقم القومي</label>
                    <input type="number" class="form-control" id="national_id" name="national_id" minlength="14" maxlength="14" placeholder="الرقم القومي" required>
                </div>
                <div class="form-group">
                    <label for="address">العنوان</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="العنوان">
                </div>
                <div class="form-group">
                    <label for="password">الرقم السري</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="الرقم السري">
                </div>

                <div class="form-group">
                    <label for="role">النوع</label>
                    <select name="role" id="role" class="form-control">
                            <option value="user">موظف</option>
                            <option value="admin">مدير</option>
                    </select>
                </div>
                <div class="form-group text-center">
                    <img id="image_preview" alt="" style="max-height:300px">
                </div>

                <div class="form-group">
                    <label for="avatar">الصورة</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
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
    <script>
        $(document).ready(function() {
            $('#avatar').change(function() {
                $('#image_preview')
                    .attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>

@stop
