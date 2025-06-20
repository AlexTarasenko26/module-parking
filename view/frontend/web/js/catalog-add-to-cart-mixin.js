define([
    'jquery',
    'ko'
], function ($, ko) {
    'use strict';

    return function (widget) {
        $.widget('mage.catalogAddToCart', widget, {
            submitForm: function (form) {
                let formEl = $(form);
                let carNumber = $('#car_number').val();
                let startTime = $('#start_time').val();
                let endTime = $('#end_time').val();

                if (!carNumber || !startTime || !endTime) {
                    alert('Please fill in all parking ticket fields before adding to cart.');
                    return false;
                }

                $('<input>', { type: 'hidden', name: 'car_number', value: carNumber }).appendTo(formEl);
                $('<input>', { type: 'hidden', name: 'start_time', value: startTime }).appendTo(formEl);
                $('<input>', { type: 'hidden', name: 'end_time', value: endTime }).appendTo(formEl);

                return this._super(form);
            }
        });

        return $.mage.catalogAddToCart;
    };
});
