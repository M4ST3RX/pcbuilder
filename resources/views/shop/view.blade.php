@extends('layouts.app')

@php
    $player = \App\Player::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
@endphp

@section('content')
    <div class="d-flex col-md-8 offset-md-2">
        <div class="row mr-3" style="height: fit-content;">
            <div class="card p-2">
                <div class="card-body d-flex flex-column">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="">Option 1
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="">Option 2
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" value="" disabled>Option 3
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @if(count($products) > 0)
                @foreach($products as $product)
                    <div class="col-md-3 mb-4 d-flex align-items-stretch">
                        <div class="card" data-type="{{ $product->hardware_type_id }}">
                            <img class="card-img-top" src="https://placehold.it/286x170" alt="Card image cap">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->item_brand->name . ' ' .  $product->name }}</h5>
                                <p class="card-text">Brand: {{ $product->item_brand->name }}</p>
                                <p class="card-text">Type: {{ $product->hardware_type->type }}</p>
                                <p class="card-text">Price: ${{ $product->price }}</p>
                                <a href="{{ route('shop.buy', ['id' => $product->id]) }}" class="mt-auto align-bottom btn-block btn {{ ($player->money >= $product->price) ? 'btn-success' : 'btn-danger disabled' }}" {{ ($player->money < $product->price) ? 'disabled' : '' }}>Purchase</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
