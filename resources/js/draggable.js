$(function () {
    let isDragging = false;
    $('.slot').on('dragstart', function() {
        if($(this).attr('data-rarity') == undefined) return false;
        isDragging = true;
        $(this).addClass('dragging');
        $('.item_details_hover:not(.d-none)').addClass('d-none');
    });

    $('.slot').on('dragend', function () {
        isDragging = false;
        $(this).removeClass('dragging');
    });

    $('.slot').on('dragover', function(event) {
        event.preventDefault();
        if(!isDragging) return false;
        $(this).addClass('dragging_over');
    });

    $('.slot').on('dragleave', function () {
        if (!isDragging) return false;
        $(this).removeClass('dragging_over');
    });

    $('.slot').on('drop', function (event) {
        event.preventDefault();
        if (!isDragging) return false;
        isDragging = false;
        let old_position = $('.dragging');
        let new_position = $(this);

        old_position.removeClass('dragging');
        new_position.removeClass('dragging_over');

        let move_success = moveItem(old_position, new_position);

        if(!move_success) return false;

        request('/api/move-item', {
            "fromSlot": old_position.attr('data-slot'),
            "toSlot": new_position.attr('data-slot'),
            "fromComputer": old_position.attr('data-placeholder') !== undefined,
            "toComputer": new_position.attr('data-placeholder') !== undefined
        }, function(response){
            if(response.computer !== undefined) {
                Object.keys(response.computer).forEach(function(key) {
                    $('.computer-stat-column .' + key + ' h3').text(response.computer[key]);
                });
            }
        }, function() {
            moveItem(new_position, old_position);
        });
    });
});

function moveItem($from_slot, $to_slot) {
    if ($from_slot.get(0) == $to_slot.get(0)) return false;

    if ($to_slot.attr('data-placeholder') !== undefined) {
        if ($from_slot.attr('data-type') != $to_slot.attr('data-placeholder')) {
            return false;
        } else {
            $to_slot.removeClass('computer-slot-empty');
        }
    }

    $temp_slot = null;

    if ($from_slot.attr('data-id') && $to_slot.attr('data-id')) {
        $temp_slot = $to_slot.clone();
    }

    $to_slot.attr('data-rarity', $from_slot.attr('data-rarity'));
    $to_slot.attr('data-type', $from_slot.attr('data-type'));
    $to_slot.attr('data-id', $from_slot.attr('data-id'));
    $to_slot.html($from_slot.html());

    if ($temp_slot != null) {
        $from_slot.attr('data-rarity', $temp_slot.attr('data-rarity'));
        $from_slot.attr('data-type', $temp_slot.attr('data-type'));
        $from_slot.attr('data-id', $temp_slot.attr('data-id'));
        $from_slot.html($temp_slot.html());
    } else {
        $from_slot.removeAttr('data-rarity');
        $from_slot.removeAttr('data-type');
        $from_slot.removeAttr('data-id');
        $from_slot.html('');
    }

    if ($from_slot.attr('data-placeholder') !== undefined && $temp_slot == null) {
        $from_slot.addClass('computer-slot-empty');
    }

    return true;
}
