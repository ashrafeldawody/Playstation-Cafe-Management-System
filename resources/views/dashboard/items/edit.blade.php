@extends('adminlte::page')

@section('title', 'المنتجات')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">
                تعديل المنتج - {{ $item->name }}
            </h3>
        </div>
        <form action="{{ route('items.update',$item->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('includes.errors')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required value="{{ $item->name }}">
                </div>
                <div class="form-group">
                    <label for="devices_category_id">النوع</label>
                    <select name="items_category_id" id="items_category_id" class="form-control">
                        @foreach ($itemCategories as $itemCategory)
                            <option {{ $item->items_category_id == $itemCategory->id ? 'selected' : '' }} value="{{ $itemCategory->id }}">{{ $itemCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">سعر البيع</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="سعر البيع" required value="{{ $item->price }}">
                </div>
                <div class="form-group">
                    <label for="buy_price">سعر الشراء</label>
                    <input type="number" class="form-control" id="buy_price" name="buy_price" placeholder="سعر الشراء" value="{{ $item->buy_price }}">
                </div>
                <div class="form-group text-center">
                    <img src="{{ asset('uploads/' . $item->image) }}" id="image_preview" alt="" style="max-height:300px">
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
