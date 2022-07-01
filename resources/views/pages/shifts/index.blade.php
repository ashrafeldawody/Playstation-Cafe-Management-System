@extends('layouts.dashboard')
@section('title', 'الشيفتات')
@section('content')
    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وقت البدء</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">وقت الانتهاء</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المده</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ايراد اللعب</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">ايراد الكافيه</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الخصم</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الايراد الكلي</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاوفر تايم</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">سعر الاوفر تايم</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Odd row -->
                        @foreach($shifts as $shift)
                            <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$shift->start_time}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$shift->end_time}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{\Carbon\CarbonInterval::minutes($shift->duration)->cascade()->format('%h:%I')}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{number_format(intval($shift->play_total) , 2)}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{number_format(intval($shift->cafe_total) , 2)}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{number_format(intval($shift->total_discount) , 2)}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{number_format(intval($shift->total_paid) , 2)}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{\Carbon\CarbonInterval::minutes($shift->overtime)->cascade()->format('%h:%I')}}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{number_format(intval($shift->overtimePrice) , 2)}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
