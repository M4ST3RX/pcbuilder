@extends('layouts.app')

@section('content')
    <div class="container bg-dark">
        <div class="row">
            <div class="col-md-12 py-3">
                @php
                    $index = 0;
                @endphp
                @foreach($computer->slots as $row)
                <div class="d-flex justify-content-center mb-2 computer-items">
                    @foreach($row["slots"] as $slot)
                        <x-item :slot-id="$index" :item="$inventoryManager->getItemAt($index, true)" :placeholder="$slot['type']"></x-item>
                        @php
                            $index++;
                        @endphp
                    @endforeach
                </div>
                @endforeach
                <div class="inventory">
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
                </div>
            </div>
            {{-- <div class="col-md-2">
                <div class="d-flex flex-column computer-stat-column">
                    <x-computer-stat title="Storage Size">{{ $computer->storage_size(true) }}</x-computer-stat>
                    <x-computer-stat title="Storage Speed">{{ $computer->storage_speed(true) }}</x-computer-stat>
                    <x-computer-stat title="GPU Speed">{{ $computer->gpu_speed(true) }}</x-computer-stat>
                </div>
            </div> --}}
        </div>
    </div>
    @foreach($inventoryManager->getItems() as $item)
    <div class="item_details_hover d-none" data-id="{{ $item->id }}">
        <div class="item-name">{{ $item->getName() }}</div>
        <div class="item-level">{{ $item->getItemLevel() }}</div>
        <div class="item-quality d-flex justify-content-start align-items-center">
            <div class="progress">
                <div class="progress-bar quality-bar-{{ $item->getItemQualityName() }}" style="width: {{ $item->quality }}%" role="progressbar" aria-valuenow="{{ $item->quality }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="item-quality-number">{{ $item->quality }}</div>
        </div>
        <div class="attributes-list">
            <div class="title">Random Attributes</div>
            <div class="attributes">
                {!! $item->getItemAttributes() !!}
            </div>
        </div>
    </div>
    @endforeach
@endsection
