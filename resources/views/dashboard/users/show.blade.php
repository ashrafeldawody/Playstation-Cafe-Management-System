@extends('adminlte::page')

@section('title', $user->name)

@section('content_header')

@stop

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>الملف الشخصي</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('includes.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="{{ asset('uploads/' . $user->avatar) }}"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">
                                @if($user->role == 'admin')
                                    مدير
                                @else
                                    مستخدم
                                @endif
                            </p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>تاريخ التعيين</b> <a class="float-right">
                                        {{ $user->created_at->format('Y-m-d') }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>عدد الساعات</b> <a class="float-right">
                                        {{ $user->hours() }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>المرتب الشهري</b> <a class="float-right">
                                        {{ $user->monthly_salary }}
                                    </a>
                                </li>
                                <li class="list-group-item">
                                    <b>ساعات الورديه</b> <a class="float-right">
                                        {{ $user->shift_hours }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card rtl">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills px-0">
                                <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">التفاصيل
                                        الشخصية</a></li>
                                <li class="nav-item"><a class="nav-link" href="#salary" data-toggle="tab">المرتب</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content text-right">
                                <div class="active tab-pane" id="details">
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <h4>الاسم</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ $user->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <h4>البريد الالكتروني</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ $user->email }}</h4>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <h4>رقم الهاتف</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ $user->phone }}</h4>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <h4>الرقم القومي</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ $user->national_id }}</h4>
                                        </div>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-6">
                                            <h4>العنوان</h4>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>{{ $user->address }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="salary">
                                        @if($user->salaries->count() == 0)
                                            <div class="alert alert-danger text-center">
                                                <b> لا يوجد مرتبات بعد</b>
                                            </div>
                                        @else
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>التاريخ</th>
                                                        <th>المرتب</th>
                                                        <th>مبلغ اضافي</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($user->salaries as $salary)
                                                        <tr>
                                                            <td>{{Carbon\Carbon::parse($salary->created_at)->locale('ar-EG')->isoFormat('Y-M-D hh:mm A')}}</td>
                                                            <td>
                                                                    {{ $salary->amount }}
                                                                    جنيه
                                                            </td>
                                                            <td>{{ $salary->is_bonus ? 'نعم' : 'لا' }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                        @endif
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">اضافة مرتب</h3>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ route('salaries.store') }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="amount">المبلغ</label>
                                                    <input type="number" name="amount" id="amount" min="1" value="200"  class="form-control">
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="is_bonus">
                                                    <label class="form-check-label mx-3" for="is_bonus">
                                                        مبلغ اضافي
                                                    </label>
                                                </div>
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-primary mt-2">اضافة</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')

@stop

@section('js')
    <script></script>
@stop
