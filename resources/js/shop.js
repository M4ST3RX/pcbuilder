const moment = require('moment');
window.moment = moment;

let end = moment().endOf('day');
let countdown_id;

request(getApiURL('reset-datetime'), {}, function (response) {
    end = moment(response.date);
});

function showHideCards(isClear, list, dataType) {
    if(isClear) {
        $('.js-shop-item').each(function() {
            $(this).removeClass('d-none');
            $(this).addClass('d-flex');
        });
    } else {
        $('.js-shop-item').each(function() {
            let data = $(this).data(dataType);
            if(list.includes(data)) {
                $(this).removeClass('d-none');
                $(this).addClass('d-flex');
            } else {
                $(this).removeClass('d-flex');
                $(this).addClass('d-none');
            }
        });
    }
}

$(function() {
    $('.reset-datetime').each(function () {
        $(this).text('Calculating...');
    });

   $('.js-section-band input[type="checkbox"]').change(function() {
       let isClear = true;
       let brandList = [];

       $('.js-section-band input[type="checkbox"]').each(function() {
          if($(this).is(':checked')) {
              isClear = false;
              brandList.push($(this).data('brand'));
          }
       });

       showHideCards(isClear, brandList, 'brand');
   });


    $('.js-section-type input[type="checkbox"]').change(function() {
        let isClear = true;
        let typeList = [];

        $('.js-section-type input[type="checkbox"]').each(function() {
            if($(this).is(':checked')) {
                isClear = false;
                typeList.push($(this).data('type'));
            }
        });

        showHideCards(isClear, typeList, 'type');
    });

    $('.shop_buy_btn').on('click', function(){
       let item = $(this).data('item');
        request(window.getApiURL('shop/buy'), {item: item});
    });

    $('.shop-tab a').on('click', function() {
        clearInterval(countdown_id);
        $('.reset-datetime').each(function () {
            $(this).text('Calculating...');
        });
        request(getApiURL('reset-datetime'), {shop: $(this).data('id')}, function(response) {
            end = moment(response.date);
            countdown_id = setInterval(displayCountdown, 1000);
        });
    });

    countdown_id = setInterval(displayCountdown, 1000);
});

function displayCountdown() {
    if(end !== undefined && end !== null) {
        let diff = end.unix() - moment().unix();
        let duration = moment.duration(diff, 'seconds');
        let duration_days = duration.days() > 0 ? duration.days() + ' days ' : '';
        let duration_hours = duration.hours() > 0 ? duration.hours() + ' hours ' : '';
        let duration_minutes = duration.minutes() > 0 ? duration.minutes() + ' minutes ' : '';
        let duration_seconds = duration.seconds() > 0 ? duration.seconds() + ' seconds' : '0 seconds';
        $('#nav-tabContent .show').find('.reset-datetime').text(duration_days + duration_hours + duration_minutes + duration_seconds);
    }
}
