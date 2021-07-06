define([
    'jquery',
    'Magento_Customer/js/customer-data',
    'uiRegistry'
], function ($, storage, registry) {
    'use strict';

    return function (checkoutData) {

        var cacheKey = 'printq-custom-fields-data',

            /**
             * @param {Object} data
             */
            saveData = function (data) {
                storage.set(cacheKey, data);
            },

            /**
             * @return {*}
             */
            initData = function () {
                return {
                    'shipping': {},
                    'billing' : {},
                    'payment' : {},
                };
            },

            /**
             * @return {*}
             */
            getData  = function () {
                var data = storage.get(cacheKey)();

                if ($.isEmptyObject(data)) {
                    data = $.initNamespaceStorage('mage-cache-storage').localStorage.get(cacheKey);

                    if ($.isEmptyObject(data)) {
                        data = initData();
                        saveData(data);
                    }
                }

                return data;
            };

        var mixin = {

            /**
             * Setting the shipping address pulled from persistence storage
             *
             * @param {Object} data
             */
            setPrintqCustomFields: function (data) {
                var obj = getData();

                $.extend(obj, data);
                saveData(obj);
            },

            /**
             * Pulling the shipping address from persistence storage
             *
             * @return {*}
             */
            getPrintqCustomFields: function () {
                return getData();
            },
        };

        checkoutData = $.extend(checkoutData, mixin);

        registry.async('checkoutProvider')(function (checkoutProvider) {
            var data = checkoutData.getPrintqCustomFields()
            if (data) {
                checkoutProvider.printqCustomFields = data;
            }

            checkoutProvider.on('printqCustomFields', function (printqCustomFields) {
                checkoutData.setPrintqCustomFields(printqCustomFields);
            });
        });

        return checkoutData;
    };
});
