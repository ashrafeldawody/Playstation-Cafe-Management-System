@extends('adminlte::page')

@section('title', 'التقارير')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>التقارير</h1>
        <div>
            <form action="{{ route('reports.index') }}" method="get" class="row">
                <input type="date" class="form-control col-5" name="start_time" value="{{old('start_time', request()->start_time) }}">
                <input type="date" class="form-control col-5" name="end_time" value="{{old('end_time', request()->end_time) }}">
                <button type="submit" class="btn btn-primary  col-2">بحث</button>
            </form>
        </div>
    </div>
@stop

@section('content')
    <div class="invoice p-3 mb-3 text-right" style="direction:rtl">
        <div class="d-flex justify-content-between">
            <h4>
                تقرير مالي
                <i class="fas fa-file-invoice"></i>
            </h4>
            <h5>{{ \Carbon\Carbon::now()->format('Y-m-d h:i:s A') }}</h5>
        </div>
        <div class="row invoice-info my-3">
            <div class="col-sm-6 invoice-col">
                تاريخ البداية:
                    <span class="text-bold">{{ request()->get('start_time') ?? 'غير محددة' }}</span>
            </div>
            <div class="col-sm-6 invoice-col">
                تاريخ النهاية:
                    <span class="text-bold">{{ request()->get('end_time') ?? 'غير محددة' }}</span>
            </div>
        </div>

        <!-- Table row -->
        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped  table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الجهاز</th>
                        <th>وقت محدود</th>
                        <th>تفاصيل اللعب</th>
                        <th>تفاصيل الكافية</th>
                        <th>المجموع</th>
                        <th>الخصم</th>
                        <th>الاجمالي</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bills as $bill)
                    <tr>
                        <td>{{ $bill->id }}</td>
                        <td>{{ $bill->device?->name }}</td>
                        <td>{{ $bill->time_limit ? $bill->time_limit / 30 . ' دقيقة ' : '' }}</td>
                        <td>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>البداية</th>
                                    <th>النهايه</th>
                                    <th>النوع</th>
                                    <th>المدة</th>
                                    <th>التكلفة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bill->sessions as $session)
                                    <tr>
                                        <td>{{ $session->start_time }}</td>
                                        <td>{{ $session->end_time }}</td>
                                        <td>{{ $session->is_multi ? 'مالتى':'عادي' }}</td>
                                        <td>{{ $session->duration }}</td>
                                        <td>{{ $session->cost }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <h5 class="float-end text-left">
                                الاجمالي:
                                {{ $bill->play_total }}
                                جنيه
                            </h5>

                        </td>
                        <td>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>السلعة</th>
                                    <th>الكمية</th>
                                    <th>السعر</th>
                                    <th>الاجمالي</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($bill->items as $item)
                                    <tr>
                                        <td>{{ $item->item->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->price }}</td>
                                        <td>{{ $item->quantity * $item->price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <h5 class="float-end text-left">
                                الاجمالي:
                                {{ $bill->cafe_total }}
                                جنيه
                            </h5>
                        </td>
                        <td>{{ $bill->cafe_total + $bill->play_total }}</td>
                        <td>{{ $bill->discount }}</td>
                        <td>{{ $bill->paid }}</td>
                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <hr>
        <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">

            </div>
            <!-- /.col -->
            <div class="col-6">

                <div class="table-responsive">
                    <table class="table">
                        @foreach($stats as $stat)
                        <tr>
                            <th style="width:50%">{{ $stat['title'] }}:</th>
                            <td>{{ $stat['value'] . ' ' . $stat['append'] }} </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-12">
                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                    Payment
                </button>
                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                </button>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop
