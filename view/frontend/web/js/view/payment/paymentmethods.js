define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'paymentmethods',
                component: 'Printq_PaymentMethods/js/view/payment/method-renderer/paymentmethods-method'
            }
        );
        return Component.extend({});
    }
);