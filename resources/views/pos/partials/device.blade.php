<div class="col-12 col-md-6 col-lg-4">
    <div class="card text-center">
        <div class="p-2 bg-gray-light d-flex justify-content-between align-content-center">
            <h3>{{$device->name}}</h3>
            <button class="btn btn-primary">
                <i class="fas fa-exchange-alt"></i>
            </button>
        </div>
        <div class="card-body">
            <p class="display-1 timeLabel" data-start="{{$device->activeBill?->sessions[0]->start_time}}">00:00:00</p>
            @if($device->activeBill)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">البداية</th>
                        <th scope="col">النهاية</th>
                        <th scope="col">النوع</th>
                        <th scope="col">المدة</th>
                        <th scope="col">التكلفة</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($device->activeBill?->sessions as $session)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($session->start_time)->locale('ar_EG')->isoFormat('hh:mm:ss A') }}</td>
                            <td>{{$session->end_time ? \Carbon\Carbon::parse($session->end_time)->locale('ar_EG')->isoFormat('hh:mm:ss A') : 'جارية'}}</td>
                            <td>{{$session->is_multi ? 'مالتي':'عادي'}}</td>
                            <td>{{ round($session->duration / 60) }}</td>
                            <td>{{$session->cost}} {{ $currency }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4">المجموع</th>
                        <th>{{$device->activeBill?->sessions->sum('cost')}} {{ $currency }}</th>
                    </tr>
                    </tfoot>
                </table>
            @endif
            @if($device->activeBill && $device->activeBill->tempItems->count() > 0)
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">السلعة</th>
                        <th scope="col">الكمية</th>
                        <th scope="col">السعر</th>
                        <th scope="col">الاجمالي
                            {{ $currency }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach ($device->activeBill?->tempItems as $item)
                        <tr>
                            <td>{{$item->item->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->price}}</td>
                            <td>{{$item->quantity * $item->item->price}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endif
        </div>
        <div class="card-footer">
            @if($device->activeBill)
                <div class="row">
                    <div class="col-3">
                        <button class="btn btn-danger btn-block deleteBill" data-bill-id="{{$device->activeBill->id}}">
                            <i class="fas fa-trash"></i>
                            <span>حذف</span>
                        </button>
                    </div>

                    <div class="col-5">
                        <button class="btn btn-info btn-block toggleMulti" data-bill-id="{{$device->activeBill->id}}">
                            <i class="fas fa-{{ $device->activeBill->sessions[$device->activeBill->sessions->count() - 1]->is_multi ? 'user' : 'users' }}"></i>
                            <span>تحويل</span>
                            <span>
                                {{ $device->activeBill->sessions[$device->activeBill->sessions->count() - 1]->is_multi ? 'عادي' : 'مالتي' }}
                            </span>
                        </button>
                    </div>
                    <div class="col-4">
                        <button class="btn btn-success btn-block">
                            <span>دفع</span>
                            <i class="fas fa-check"></i>
                        </button>
                    </div>
                </div>
            @else
                <form action="{{route('pos.play.start')}}" method="POST">
                    @csrf
                    <input type="hidden" name="device_id" value="{{$device->id}}">
                    <div class="row">
                        <div class="col-6">
                            <select class="form-control" name="time_limit">
                                <option value="0">وقت مفتوح</option>
                                @for($i = 30; $i <= 380; $i += 30)
                                    <option value="{{ $i }}">
                                        {{ \Carbon\Carbon::parse($i * 60)->format('H:i') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch
                                   data-off-color="danger" data-on-color="success">
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-play ml-2"></i>
                                بدء
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
