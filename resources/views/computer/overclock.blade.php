@extends('layouts.app')

@section('content')
    <div class="container h-100 bg-dark">
        <div class="row h-100">
            <div class="col-md-3 inventory-list h-100">
                @foreach ($inventoryManager->getItems() as $item)
                    <x-list-item :item="$item"></x-list-item>
                @endforeach
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="rounded m-4 mb-5" style="border: 1px solid white">
                            <div class="m-2">
                                <div class="oc-title">Repair</div>
                            </div>
                            <div class="m-2">
                                <div class="oc-text">
                                    Price:
                                    <div class="d-inline-flex oc-price ">${{rand(100,300)}}</div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="m-2">
                                    <button type="submit" class="btn btn-danger">Scrap</button>
                                </div>
                                <div class="m-2">
                                    <button type="submit" class="btn btn-primary">Repair</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="rounded m-4 mb-5" style="border: 1px solid white">
                            <div class="m-2">
                                <div class="oc-title">Boost</div>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range">
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="m-2">
                                    <button type="submit" class="btn btn-primary">Boost</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded m-4 mb-5" style="border: 1px solid white">
                            <div class="m-2">
                                <div class="oc-title">title</div>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range" name="points1">
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="m-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="rounded m-4 mb-5" style="border: 1px solid white">
                            <div class="m-2">
                                <div class="oc-title">title</div>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range" name="points1">
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="m-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
