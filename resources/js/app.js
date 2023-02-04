/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./functions');
require('./shop');
require('./draggable');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$.fn.overflown = function () { var e = this[0]; return e.scrollHeight > e.clientHeight || e.scrollWidth > e.clientWidth; }

$(function(){
   $(".add-part").on('click', function(){
       let part = $(this).data('part');
       let modal = $("#part-select-modal");
       modal.find('.save-part').data('part', part);
       request(window.getApiURL('items'), {type: part}, function (response) {
           let select = modal.find("select");
           select.empty();
           select.append($('<option>', {
               value: null,
               disabled: true,
               selected: true,
               text: "Please Select"
           }));
           response.forEach(function (item) {
               select.append($('<option>', {
                   value: item.id,
                   text: item.hardware.item_brand.name + " " + item.hardware.name
               }));
           });

           modal.modal('show');
       });
   });

   $('.save-part').on('click', function (){
       let selected_item = $('#new-part').find(':selected');
       if(selected_item.val() == null) return;

       let part = $(this).data('part');

       $('.part-' + part).data('item', selected_item.val());
       $('.part-' + part + ' .part-row span').text(selected_item.text());

       switch (part) {
           case "case":
               $('.part-motherboard').removeClass('d-none');
               $('.part-psu').removeClass('d-none');
               break;
           case "motherboard":
               $('.part-cpu').removeClass('d-none');
               $('.part-videocard').removeClass('d-none');
               $('.part-ram').removeClass('d-none');
               $('.part-storage').removeClass('d-none');
               break;
           default:
               break;
       }

       $("#part-select-modal").modal('hide');
   });

    $('.computer-card').on('click', function() {
        let $this = $(this);
        if($this.data('id')) {
            request(window.getApiURL('login'), { computer_id: $this.data('id') }, function(response) {
                if(!response.error) {
                    window.location.href = getBaseURL() + "/computer";
                }
            });
        } else {
            window.location.href = getBaseURL() + "/create";
        }
    });

    $('.miner_toggle').on('click', function() {
        let $this = $(this);
        request(window.getApiURL('miner/mine'), {mine_id: $this.parents('.card').data('id')}, function(response) {
            if(!response.error) {
                if(response.started) {
                    $this.removeClass('btn-primary');
                    $this.addClass('btn-success');
                    $this.text('Collect');
                } else {
                    $this.removeClass('btn-success');
                    $this.addClass('btn-primary');
                    $this.text('Mine Coins');
                }
            }
        });
    });

    $('.miner_sell').on('click', function() {
        let $this = $(this);
        request(window.getApiURL('miner/sell'), {mine_id: $this.parents('.card').data('id')}, function(response) {
            console.log(response);
        });
    });

    $('.slot').on('mouseenter', function(event) {
        let $this = $(this);
        let position = $this.offset();
        let top = position.top;
        let left = position.left + 60;

        if($this.attr('data-type') !== undefined) {

            let item_details_div = $('.item_details_hover[data-id="' + $this.attr('data-id') + '"]');
            item_details_div.removeClass('d-none');

            if (position.top + item_details_div.height() + 24 >= $(document).height()) {
                top = position.top - item_details_div.height() + 24;
            }

            item_details_div.css({
                'top': top + "px",
                'left': left + "px"
            });
        }
    });


    $('.slot').on('mouseleave', function (event) {
        let item_details_div = $('.item_details_hover');
        item_details_div.addClass('d-none');
    });
});
