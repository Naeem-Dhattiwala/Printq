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
                type: 'lastschrift',
                component: 'Printq_Lastschrift/js/view/payment/method-renderer/lastschrift-method'
            }
        );
        return Component.extend({});
    }
);