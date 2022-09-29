<div class="card text-right mx-1" style="cursor: pointer">
    <img class="card-img-top" style="width: auto;height:200px;" src="{{ asset('uploads/' . $item->image) }}" alt="Card image cap">
    <div class="card-body">
        <h5>{{ $item->name }}</h5>
        <div class="badge badge-primary">{{ $item->price }} {{ $currency }}</div>
    </div>
</div>
