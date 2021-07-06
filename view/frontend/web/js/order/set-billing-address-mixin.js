// /*jshint browser:true jquery:true*/
// /*global alert*/
// define( [
//     'jquery',
//     'mage/utils/wrapper',
//     'Printq_CheckoutFields/js/order/additional-comment-assigner'
// ], function( $, wrapper, quote ) {
//     'use strict';
//
//     return function( setBillingAddressAction ) {
//
//         return wrapper.wrap( setBillingAddressAction, function( originalAction ) {
//             var billingAddress = quote.billingAddress();
//             if ( billingAddress && billingAddress.customAttributes ) {
//                 if ( billingAddress['extension_attributes'] === undefined ) {
//                     billingAddress['extension_attributes'] = {};
//                 }
//                 var taxcode = billingAddress.customAttributes['tax_code'];
//                 if ( $.isPlainObject( taxcode ) ) {
//                     taxcode = taxcode['value'];
//                 }
//                 billingAddress['extension_attributes']['tax_code'] = taxcode;
//                 // pass execution to original action ('Magento_Checkout/js/action/set-shipping-information')
//             }
//             return originalAction();
//         } );
//     };
// } );
