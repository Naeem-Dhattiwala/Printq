define([
    'jquery',
    'mage/utils/wrapper',
    'Printq_CheckoutFields/js/order/additional-comment-assigner'
], function ($, wrapper, additionalCommentAssigner) {
    'use strict';

    return function (placeOrderAction) {

        /** Override place-order-mixin for set-payment-information action as they differs only by method signature */
        return wrapper.wrap(placeOrderAction, function (originalAction, messageContainer, paymentData) {
            additionalCommentAssigner(paymentData);
            return originalAction(messageContainer, paymentData);
        });
    };
});
