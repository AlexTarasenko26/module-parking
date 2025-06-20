define([
    'uiComponent',
    'ko',
    'jquery',
    'mage/storage'
], function (Component, ko, $, storage) {
    'use strict';

    return Component.extend({
        defaults: {
            carNumber: '',
            startTime: '',
            endTime: '',
            isParkingTicket: false,
            template: 'Epam_Parking/product/parking-fields'
        },
        getTemplate: function () {
            return this.template;
        },

        initialize: function (config) {
            this._super();

            this.config = config || {};

            this.carNumber = ko.observable('').extend({ required: true })
            this.startTime = ko.observable('').extend({ required: true })
            this.endTime = ko.observable('').extend({ required: true })


            return this;
        }
    });
});
