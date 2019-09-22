@extends('layouts.app')

@section('content')
    <div class="container">
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
                                <a href="{{ route('shop.buy', ['id' => $product->id]) }}" class="mt-auto align-bottom btn-block btn {{ (Auth::user()->money >= $product->price) ? 'btn-success' : 'btn-danger disabled' }}">Purchase</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
