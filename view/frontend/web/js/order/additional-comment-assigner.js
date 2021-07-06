define([
    'jquery'
], function ($) {
    'use strict';

    /** Override default place order action and add extension attributes to request */
    return function (paymentData) {

        if (paymentData['extension_attributes'] === undefined) {
            paymentData['extension_attributes'] = {};
        }
        var data = window.checkoutConfig.name;
        var count = (data.match(/,/g) || []).length;
        // alert(count);
        var paymentcode = [];
        for (var i=0; i < count; i++){
            paymentcode = [data.split(",")[i]];
            var name = "printqCustomFields[payment][" + paymentcode + ']';
            console.log(name);
            console.log($('[name="'+ name +'"]').val());
            paymentData['extension_attributes']['payment_custom_attributes'] += jQuery('[name="'+ name +'"]').val() + '/';
            paymentData['extension_attributes']['payment_custom_attributes_2'] += paymentcode + '/';
        };
    };
});
