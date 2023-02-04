<div data-slot="{{ $slotId }}" class="slot @if($placeholder != null && $item == null) computer-slot-empty @endif" @if($placeholder != null) data-placeholder="{{ $placeholder }}" @endif @if($item !== null) data-rarity="{{ $item->getRarity(false); }}" data-type="{{ $item->type }}" data-id="{{ $item->id }}" @endif>
    @if($item !== null)
        <img src="{{ $item->getImage(); }}" alt="" width="48px" height="48px">
    @endif
</div>
