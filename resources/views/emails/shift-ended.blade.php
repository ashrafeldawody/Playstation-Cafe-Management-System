<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <title>{{ $shift['title'] }}</title>
</head>
<body>
<h1>{{ $shift['title'] }}  - {{ $shift['date'] }}</h1>
<p>
    <span>وقت البدء: </span>
    <span>{{ $shift['startTime'] }}</span>
</p>
<p>
    <span>وقت الانتهاء: </span>
    <span>{{ $shift['endTime'] }}</span>
</p>
<div class="text-left">
    <p>
        <span>اجمالي اللعب</span>
        <span class="mx-3">{{  $shift['playTotal'] }}</span>
        <span>جنيه</span>
    </p>
    <p>
        <span>اجمالي الكافيه</span>
        <span class="mx-3">{{  $shift['cafeTotal'] }}</span>
        <span>جنيه</span>
    </p>
    <p>
        <span>اجمالي الخصم</span>
        <span class="mx-3">{{  $shift['discount'] }}</span>
        <span>جنيه</span>
    </p>
    <p>
        <span>اجمالي الدخل</span>
        <span class="mx-3">{{  $shift['paid'] }}</span>
        <span>جنيه</span>
    </p>
</div>

<style>
    table.GeneratedTable {
        width: 100%;
        background-color: #ffffff;
        border-collapse: collapse;
        border-width: 2px;
        border-style: solid;
        color: #000000;
    }

    table.GeneratedTable td, table.GeneratedTable th {
        border-width: 2px;
        border-style: solid;
        padding: 3px;
    }

    table.GeneratedTable thead {
        background-color: #ffffff;
    }
</style>

<!-- HTML Code: Place this code in the document's body (between the 'body' tags) where the table should appear -->
<table class="GeneratedTable" style="width: 100%;border: 1px solid" cellpadding="4" cellspacing="4">
    <thead>
    <tr>
        <th>الوقت</th>
        <th>اللعب</th>
        <th>الطلبات</th>
        <th>تكلفه اللعب</th>
        <th>تكلفه الكافيه</th>
        <th>الخصم</th>
        <th>الاجمالي</th>
    </tr>
    </thead>
    <tbody>
    @foreach($shift['bills'] as $bill)
        <tr class="border: 1px solid">
            <td>{{ $bill->created_at }}</td>
            <td>
                @foreach($bill->sessions as $session)
                    {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}<br>
                    = {{ $session->cost }}  جنيه
                @endforeach
            </td>
            <td>
                @foreach($bill->items as $item)
                    {{ $item->item->name }}
                    {{ $item->price }} * {{ $item->quantity }}
                    = {{ $item->price * $item->quantity }} جنيه
                    <br>
                @endforeach
            </td>
            <td>{{ $bill->play_total }}</td>
            <td>{{ $bill->cafe_total }}</td>
            <td>{{ $bill->discount }}</td>
            <td>{{$bill->play_total + $bill->cafe_total - $bill->discount}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<hr>
</body>
</html>
