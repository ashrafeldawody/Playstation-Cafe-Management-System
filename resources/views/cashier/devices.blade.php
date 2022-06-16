@extends('cashier.layout')
@section('title', 'الأجهزة')
@section('content')
    <div class="position-fixed bottom-0 start-0 p-3" style="z-index: 11">
        <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Bootstrap</strong>
                <small>11 mins ago</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Hello, world! This is a toast message.
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>الأجهزة</h3>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach($devices as $device)
                                <div class="col" style="min-width: 400px">
                                    <div class="card h-100">
                                        <div class="card-header @if($device->activeBill) bg-danger text-white @endif d-flex justify-content-between">
                                            <h5 class="card-title">{{ $device->name }}</h5>
                                            <img src="/images/ps4.png" style="height: 2rem;width: auto" alt="...">
                                        </div>
                                        <div class="card-body text-center">
                                            <h1 class="card-text display-1" id="device{{$device->id}}">00:00:00</h1>
                                        @if($device->activeBill)
                                        <div>
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">وقت البدء</th>
                                                    <th scope="col">وقت الإنتهاء</th>
                                                    <th scope="col">النوع</th>
                                                    <th scope="col">محدد</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($device->activeBill->sessions as $session)
                                                    <tr>
                                                        <td>{{ \Carbon\Carbon::parse($session->start_time)->isoFormat('h:m a') }}</td>
                                                        <td>{{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->isoFormat('h:m a'):'جاري' }}</td>
                                                        <td>{{ $session->is_multi ? 'مالتي':'عادي'}}</td>
                                                        <td>{{ $session->time_limit ? ($session->time_limit) . ' دقيقة' : 'لا'  }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        @endif
                                        </div>
                                        <div class="card-footer d-flex justify-content-between">
                                            @if($device->activeBill)
                                                <button type="button" class="btn btn-success">انهاء ودفع</button>
                                                <button type="button" class="btn btn-danger">حذف الفاتوره</button>

                                            @else
                                                <div class="btn-group">
                                                    <button class="btn btn-success dropdown-toggle" type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                                        بدأ وقت عادي
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                                        <li><a class="dropdown-item time-list-item" data-time="0">وقت مفتوح</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        @for($minutes = 30; $minutes <= 240; $minutes+=30)
                                                            <li><button class="dropdown-item time-list-item" data-device_id="{{$device->id}}" data-time="{{ $minutes }}">{{gmdate("H:i", $minutes * 60)}}</button></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                                <div class="btn-group">
                                                    <button class="btn btn-success dropdown-toggle" type="button" id="defaultDropdown" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                                        بدء وقت مالتي
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="defaultDropdown">
                                                        <li><a class="dropdown-item time-list-item" data-time="0" data-multi="1">وقت مفتوح</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        @for($minutes = 30; $minutes <= 240; $minutes+=30)
                                                            <li><button class="dropdown-item time-list-item" data-multi="1" data-device_id="{{$device->id}}" data-time="{{ $minutes }}">{{gmdate("H:i", $minutes * 60)}}</button></li>
                                                        @endfor
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                </div>
                                </div>
                                @if($device->activeBill)
                                <script>
                                    $(document).ready(function () {
                                        let timerLabel = document.getElementById('device{{$device->id}}');
                                        let startTime = new Date("{{\Carbon\Carbon::parse($device->activeBill->sessions->last()->start_time)->toDateTimeLocalString()}}");
                                        let time_limit = {{($device->activeBill->sessions->last()->time_limit)? $device->activeBill->sessions->last()->time_limit : 0}};

                                        let timer = setInterval(function () {
                                            let now = new Date();
                                            let timeDiff = now - startTime;
                                            let diff = new Date(timeDiff);
                                            let hours = diff.getUTCHours();
                                            let minutes = diff.getUTCMinutes();
                                            let seconds = diff.getUTCSeconds();

                                            timerLabel.innerHTML = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
                                        }, 1000);
                                    });
                                </script>
                                @endif
                            @endforeach
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.time-list-item').click(function () {
                var toastElList = [].slice.call(document.querySelectorAll('.toast'))
                var toastList = toastElList.map(function(toastEl) {
                    // Creates an array of toasts (it only initializes them)
                    return new bootstrap.Toast(toastEl) // No need for options; use the default options
                });
                toastList.forEach(toast => toast.show()); // This show them

                console.log(toastList); // Testing to see if it works

                return;
                let time = $(this).data('time');
                let is_multi = $(this).data('multi') ? 1 : 0;
                let device_id = $(this).data('device_id');
                console.log(device_id);
                $.ajax({
                    url: '/api/play/start',
                    type: 'POST',
                    data: {
                        device_id: device_id,
                        time_limit: time,
                        is_multi: is_multi
                    },
                    success: function (data) {
                        console.log(data);
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
