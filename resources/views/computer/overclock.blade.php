@extends('layouts.app')

@section('content')
    <div class="container bg-dark h-100">
        <div class="row h-100">
            <div class="col-md-3 inventory-list h-100">
                @foreach ($inventoryManager->getItems() as $item)
                    <x-list-item :item="$item"></x-list-item>
                @endforeach
            </div>
            <div class="col-md-9">
            </div>
        </div>
    </div>
    @foreach($inventoryManager->getItems() as $item)
    <div class="item_details_hover d-none" data-id="{{ $item->id }}">
        <div class="item-name">{{ $item->getName() }}</div>
        <div class="item-level">{{ $item->getLevel() }}</div>
        <div class="item-quality d-flex justify-content-start align-items-center">
            <div class="progress">
                <div class="progress-bar quality-bar-{{ $item->getItemQualityName() }}" style="width: {{ $item->quality }}%" role="progressbar" aria-valuenow="{{ $item->quality }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="item-quality-number">{{ $item->quality }}</div>
        </div>
        <div class="attributes-list">
            <div class="attributes">
                {!! $item->getItemAttributes() !!}
            </div>
        </div>
    </div>
    @endforeach
@endsection
