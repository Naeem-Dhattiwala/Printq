var config = {
    config: {
        mixins: {
             'Magento_Checkout/js/action/place-order': {
                 'Printq_CheckoutFields/js/order/place-order-mixin': true
            },
            'Magento_Checkout/js/action/set-payment-information': {
                'Printq_CheckoutFields/js/order/set-payment-information-mixin': true
            },
            'Magento_Checkout/js/model/shipping-save-processor/payload-extender': {
                'Printq_CheckoutFields/js/model/shipping-save-processor/payload-extender-mixin': true
            },
            'Magento_Checkout/js/checkout-data': {
                'Printq_CheckoutFields/js/checkout-data-mixin': true
            }
        }
    }
};
