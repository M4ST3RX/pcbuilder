@extends('layouts.app')

@section('content')
    <div class="container p-2 bg-dark">
        <div class="nav nav-tabs mb-3 shop-tab" id="nav-tab" role="tablist">
            @foreach($shops as $shop)
                <a class="nav-item nav-link {{ $shop->id == 1 ? 'active' : '' }}" id="{{ strtolower(str_replace(' ', '-', $shop->name)) }}-tab" data-toggle="tab" href="#{{ strtolower(str_replace(' ', '-', $shop->name)) }}" role="tab" aria-controls="{{ strtolower(str_replace(' ', '-', $shop->name)) }}" aria-selected="{{ $shop->id == 1 ? 'true' : 'false' }}" data-id="{{ $shop->id }}">{{ $shop->name }}</a>
            @endforeach
        </div>

        <div class="tab-content" id="nav-tabContent">
            @foreach($shops as $shop)
                <div class="tab-pane fade {{ $shop->id == 1 ? 'show active' : '' }} p-2" id="{{ strtolower(str_replace(' ', '-', $shop->name)) }}" role="tabpanel" aria-labelledby="{{ strtolower(str_replace(' ', '-', $shop->name)) }}-tab">
                    <div class="d-flex flex-column">
                        <div class="reset-date pb-2">Ends in: <div class="reset-datetime d-inline-flex"></div></div>
                        <div class="row">
                            @foreach($shop->items as $shop_item)
                                <div class="col-md-3 col-lg-3 mb-4 d-flex" data-type="{{ $shop_item->type }}">
                                    <div class="card card-bg-dark flex-grow-1">
                                        <div class="clear">
                                            @if($shop_item->discount > 0)
                                            <div class="ribbon-container">
                                                <div class="ribbon">{{ '-' . $shop_item->discount . '%' }}</div>
                                            </div>
                                            @endif
                                            <div class="card-img-top d-flex justify-content-center" data-rarity="{{ $shop_item->getRarity(false) }}">
                                                <img src="{{ $shop_item->getImage() }}" alt="Card image cap">
                                            </div>
                                        </div>

                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $shop_item->getName() }}</h5>
                                            <div class="card-text pb-2">Price:
                                                <div class="d-inline-flex price {{ $shop_item->discount > 0 ? 'discounted' : '' }}">{{ $shop->currency->is_front ? $shop->currency->name . $shop_item->price : $shop_item->price . ' ' . $shop->currency->name }}</div>
                                                @if($shop_item->discount > 0)
                                                    <div class="d-inline-flex">{{ $shop->currency->is_front ? $shop->currency->name . $shop_item->getPrice() : $shop_item->getPrice() . ' ' . $shop->currency->name }}</div>
                                                @endif
                                            </div>
                                            <button data-item="{{ $shop_item->id }}" class="mt-auto align-bottom btn-block shop_buy_btn btn btn-success }}">Purchase</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
