window.request = function (url, data, successCb = null, errorCb = null, alwaysCb = null, finallyCb = null) {
    if(!successCb || typeof successCb !== 'function') {
        successCb = function(response){
            let modal = $('#success-alert');
            modal.find('.modal-title').text(response.title);
            modal.find('.modal-body').html(response.message);
            modal.modal('show');
        }
    }

    if(!errorCb || typeof errorCb !== 'function') {
        errorCb = function(response){
            let modal = $('#error-alert');
            modal.find('.modal-title').text(response.title);
            modal.find('.modal-body').html(response.message);
            modal.modal('show');
        }
    }

    if(!alwaysCb || typeof alwaysCb !== 'function') {
        alwaysCb = function(response){

        }
    }

    if(!finallyCb || typeof finallyCb !== 'function') {
        finallyCb = function(response){

        }
    }

    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        contentType: "application/json; charset=utf-8",
        data: JSON.stringify(data),
        success: function(response){
            response = JSON.parse(response);
            if(response.error) {
                errorCb(response);
            } else {
                successCb(response);
            }
        }
    }).always(alwaysCb)
        .then(finallyCb);
}

window.getBaseURL = function() {
    return window.location.protocol + "//" + window.location.hostname;
}

window.getPlaceholderImageURL = function(type) {
    return window.getBaseURL() + "/storage/images/placeholders/" + getTypeName(type) + "_placeholder.png";
}

window.getApiURL = function(url_append) {
    return window.getBaseURL() + "/api/" + url_append;
}

function getTypeName(type) {
    switch(type) {
        default:
        case "1":
            return "motherboard";
        case "2":
            return "cpu";
        case "3":
            return "graphics_card";
        case "4":
            return "hard_drive";
        case "5":
            return "memory";
        case "6":
            return "power_supply";
    }
}
