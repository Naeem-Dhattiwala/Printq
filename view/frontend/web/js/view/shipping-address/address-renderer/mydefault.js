/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Checkout/js/action/select-shipping-address',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/shipping-address/form-popup-state',
    'Magento_Checkout/js/checkout-data',
    'Magento_Customer/js/customer-data',
    'mage/translate'
], function ($, ko, Component, selectShippingAddressAction, quote, formPopUpState, checkoutData, customerData, $t) {
    'use strict';

    var countryData = customerData.get('directory-data');

    return Component.extend({
        defaults: {
            template: 'Printq_CheckoutShippingDropdown/shipping-address/address-renderer/mydefault'
        },

        /** @inheritdoc */
        initObservable: function () {
            this._super();
            this.isSelected = ko.computed(function () {
                var isSelected = false,
                    shippingAddress = quote.shippingAddress();

                if (shippingAddress) {
                  // isSelected = shippingAddress.getKey() == this.address().getKey(); //eslint-disable-line eqeqeq
                }

                return isSelected;
            }, this);

            return this;
        },

        /**
         * @param {String} countryId
         * @return {String}
         */
        getCountryName: function (countryId) {
            return countryData()[countryId] != undefined ? countryData()[countryId].name : ''; //eslint-disable-line
        },
         addressOptionsText: function (address) {
              if(address.customerAddressId){
                   return address.getAddressInline();
              } else {
                  //var newAddressInline =  address.firstname +' ' + address.lastname +', '+ address.street[0]+', ' + address.city+', ' + address.region
                  //return '[ '+ $t('New Address')+']' + newAddressInline ;
                  return $t('New Address');
              }

        },
        /*selectedAddress: function(param){
            console.log("address param");
              console.log(param);
        },*/
        /** Set selected customer shipping address  */
        onAddressChange: function (address) {   
            selectShippingAddressAction(this.allAddress());
            checkoutData.setSelectedShippingAddress(this.allAddress().getKey());
        },      

        /**
         * Edit address.
         */
        editAddress: function () {
            formPopUpState.isVisible(true);
            this.showPopup();

        },
        /**
         * Show popup.
         */
        showPopup: function () {
            $('[data-open-modal="opc-new-shipping-address"]').trigger('click');
        }
    });
});