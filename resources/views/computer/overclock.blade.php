@extends('layouts.app')

@section('content')
    <div class="container bg-dark">
        <div class="row">
            <div class="col-md-3">
                {{-- <div class="inventory">
                    <div class="inventory-container">
                        <div class="title">
                            Inventory
                        </div>
                        <div class="inventory-items">
                            @for($i = 0; $i < App\Managers\InventoryManager::$MAX_SLOTS; $i++)
                                @php
                                    $item = $inventoryManager->getItemAt($i);
                                @endphp
                                <x-item :item="$item" :slot-id="$i"/>
                            @endfor
                        </div>
                    </div>
                </div> --}}
                <h1>inventory</h1>
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="rounded m-4 mb-5" style="border: 1px solid white">
                            <div class="m-2">
                                <h1>cim</h1>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range" id="customRange" name="points1">
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
                                <h1>cim</h1>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range" id="customRange" name="points1">
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
                                <h1>cim</h1>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range" id="customRange" name="points1">
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
                                <h1>cim</h1>
                            </div>
                            <div class="m-2">
                                <input type="range" class="custom-range" id="customRange" name="points1">
                            </div>

                            <div class="d-flex justify-content-end">
                                <div class="m-2">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div></div>
                    <div></div>
                </div>
            </div>

        </div>

        </div>
        <div></div>
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
