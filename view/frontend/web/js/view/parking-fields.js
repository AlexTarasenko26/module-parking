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
            zoneId: '',
            zonesUrl: '',
            isParkingTicket: false,
            template: 'Epam_Parking/product/parking-fields'
        },
        getTemplate: function () {
            return this.template;
        },

        initialize: function (config) {
            this._super();

            this.config = config || {};

            this.carNumber = ko.observable(this.config.carNumber || '');
            this.startTime = ko.observable(this.config.startTime || '');
            this.endTime = ko.observable(this.config.endTime || '');
            this.zoneId = ko.observable(this.config.zoneId || '');
            this.zones = ko.observableArray([]);

            if (this.config.isParkingTicket) {
                this.loadZones();
            }

            return this;
        },

        loadZones: function () {
            var self = this;
            storage.get(this.config.zonesUrl).done(function (data) {
                self.zones(data);
            });
        },

        isVisible: function () {
            return this.config.isParkingTicket;
        }
    });
});
