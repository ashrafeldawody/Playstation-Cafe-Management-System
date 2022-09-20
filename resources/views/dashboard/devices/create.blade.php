@extends('adminlte::page')

@section('title', 'الأجهزة')


@section('content')
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">اضافة جهاز</h3>
        </div>
        <form action="{{ route('devices.store') }}" method="POST">
            @csrf
            @include('includes.errors')
            <div class="card-body">
                <div class="form-group">
                    <label for="name">الإسم</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="الاسم" required>
                </div>
                <div class="form-group">
                    <label for="devices_category_id">النوع</label>
                    <select name="devices_category_id" id="devices_category_id" class="form-control">
                        @foreach ($deviceCategories as $deviceCategory)
                            <option value="{{ $deviceCategory->id }}">{{ $deviceCategory->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="games">الألعاب</label>
                    <div>
                        @foreach ($games as $game)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="game{{ $game->id }}" name="games[]" value="{{ $game->id }}">
                                <label class="form-check-label" for="game{{ $game->id }}">{{ $game->name }}</label>
                            </div>
                        @endforeach
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
