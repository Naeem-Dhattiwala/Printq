define([
    'jquery',
    'mage/utils/wrapper',
    'Printq_CheckoutFields/js/order/additional-comment-assigner'
], function ($, wrapper, additionalCommentAssigner) {
    'use strict';

    return function (placeOrderAction) {

        /** Override default place order action and add extension attributes to request */
        return wrapper.wrap(placeOrderAction, function (originalAction, paymentData, messageContainer) {
            additionalCommentAssigner(paymentData);
            return originalAction(paymentData, messageContainer);
        });
    };
});
