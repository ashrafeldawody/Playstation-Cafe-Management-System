@extends('adminlte::page')

@section('title', 'المصروفات')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">تسجيل مصروفات</h3>
        </div>
        <form action="{{ route('expenses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('includes.errors')
            <div class="card-body">
                <div class="form-group">
                    <label for="type">النوع</label>
                    <select name="type" id="type" class="form-control">
                        <option value="مصاريف">مصاريف</option>
                        <option value="فواتير">فواتير</option>
                        <option value="صيانة">صيانة</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">القيمة</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="القيمة" required>
                </div>
                <div class="form-group">
                    <label for="description">التفاصيل</label>
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
                </div>
                <div class="form-group text-center">
                    <img id="image_preview" alt="" style="max-height:300px">
                </div>
                <div class="form-group">
                    <label for="quantity">الصورة</label>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
                </div>
        </form>
    </div>
@stop

@section('css')

@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#image').change(function() {
                $('#image_preview')
                    .attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>

@stop
