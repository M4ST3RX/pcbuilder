<div data-slot="{{ $slotId }}" class="slot @if($placeholder != null && $item == null) computer-slot-empty @endif" @if($placeholder != null) data-placeholder="{{ $placeholder }}" @endif @if($item !== null) data-rarity="{{ $item->prefab->getRarity(false); }}" data-type="{{ $item->prefab->type }}" data-id="{{ $item->id }}" @endif>
    @if($item !== null)
        <img src="{{ $item->prefab->getImage(); }}" alt="" width="48px" height="48px">
    @endif
</div>
