@extends('adminlte::page')

@section('title', 'المخزون')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">اضافة للمخزون</h3>
        </div>
        <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('includes.errors')
            <div class="card-body">
                <div class="form-group">
                    <label for="item_id">النوع</label>
                    <select name="item_id" id="item_id" class="form-control">
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">النوع</label>
                    <select name="type" id="type" class="form-control">
                        <option value="BUY">وارد</option>
                        <option value="RETURN">استرجاع</option>
                        <option value="DEFECT">مفقود</option>
                        <option value="LOST">تالف</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">الكمية</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="الكمية" required>
                </div>

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
