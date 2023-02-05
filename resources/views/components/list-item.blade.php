<div class="w-100 my-2 list_item" style="border: 2px solid black">
    <div class="item-list-container d-flex">
        <div class="item-img d-flex align-self-center" data-rarity="{{ $item->getRarity(false); }}">
            <img src="{{ $item->getImage() }}" alt="" width="48px" height="48px">
        </div>
        <div class="item-stats w-100">
            <div class="item-name">
                {{ $item->getName() }}
            </div>
            <div class="item-quality d-flex justify-content-start align-items-center">
                <div class="progress mr-2">
                    <div class="progress-bar quality-bar-{{ $item->getItemQualityName() }}" style="width: {{ $item->quality }}%" role="progressbar" aria-valuenow="{{ $item->quality }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="item-quality-number">{{ $item->quality }}</div>
            </div>
        </div>
    </div>
</div>
