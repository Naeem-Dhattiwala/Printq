define(
    [
        'ko',
        'Magento_Checkout/js/view/payment/default',
        'jquery'
    ],
    function (ko, Component,$) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Printq_Lastschrift/payment/lastschrift'
            },
            getData: function() {
                return {
                    'method': this.item.method,
                    'additional_data': {
                        'kontoinhaber': $('#lastschrift_kontoinhaber').val(),
                        'iban': $('#lastschrift_iban').val(),
                        'bic': $('#lastschrift_bic').val(),
                    }
                };
            },
        });
    }
);
