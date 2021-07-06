define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/checkout-data',
    'uiRegistry'
], function ($, wrapper, checkoutData, registry) {
    'use strict';

    return function (payloadExtender) {
        return wrapper.wrap(payloadExtender, function (originalAction, payload) {
            payload = originalAction(payload);

            var customFields = checkoutData.getPrintqCustomFields();
            if(customFields && customFields.shipping){
                payload.addressInformation.extension_attributes.shipping_custom_attributes = JSON.stringify(customFields.shipping);
            }
            return payload;
        });
    };
});
