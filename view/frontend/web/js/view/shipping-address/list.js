/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'underscore',
    'ko',
    'mageUtils',
    'uiComponent',
    'uiLayout',
    'Magento_Customer/js/model/address-list',
    'Magento_Checkout/js/action/select-shipping-address',
    'Magento_Checkout/js/checkout-data',
    'mage/url',
    'Magento_Ui/js/modal/confirm',
    'mage/translate'
], function (_, ko, utils, Component, layout, addressList,  selectShippingAddressAction, checkoutData, url, confirmation, $t) {
    'use strict';
   /* alert(window.valuesConfig);*/
  if (window.valuesConfig == 1) {
    var defaultRendererTemplate = {
        parent: '${ $.$data.parentName }',
        name: '${ $.$data.name }',
        component: 'Printq_CheckoutShippingDropdown/js/view/shipping-address/address-renderer/default'
    };

    /* custom RendererTemplate  for Dropdown*/
    var mydefaultRendererTemplate = {
        parent: '${ $.$data.parentName }',
        name: '${ $.$data.name }',
        component: 'Printq_CheckoutShippingDropdown/js/view/shipping-address/address-renderer/mydefault'
    };
    return Component.extend({
        defaults: {
            template: 'Printq_CheckoutShippingDropdown/shipping-address/list',
            visible: addressList().length > 0,
            rendererTemplates: [],
            myAddressList: [],            
            myComponentRendererIndex:50
        },

        /** @inheritdoc */
        initialize: function () {
            this._super()
                .initChildren();

            addressList.subscribe(function (changes) {
                    var self = this;

                    changes.forEach(function (change) {
                        if (change.status === 'added') {                            
                           //self.createNewRendererComponent(change.value, change.index);
                           self.createNewRendererComponent(change.value, 0);
                           self.createRendererMyNewComponent(change.value, change.index);
                        }
                    });
                },
                this,
                'arrayChange'
            );

            return this;
        },

        /** @inheritdoc */
        initConfig: function () {
            this._super();
            // the list of child components that are responsible for address rendering
            this.rendererComponents = [];

            return this;
        },

        /** @inheritdoc */
        initChildren: function () {
           // _.each(addressList(), this.createRendererComponent, this);
            _.each(addressList(), this.createAddressListData, this);
            this.createRendererMyComponent();

            return this;
        },
         /**
         * Create arreess List Array
         *
         * @param {Object} address
         * @param {*} index
         */
        createAddressListData: function(address, index){
            //address.inlineAddress = address.getAddressInline();
            this.myAddressList.push( address );
        }, 
        /**
         * Push new shipping address
         */ 
        createRendererMyNewComponent: function(address, index) {
             if (index in this.myAddressList) {         
                 //this.rendererComponents[50].allAddress[index] = address;
             } else {
               this.rendererComponents[this.myComponentRendererIndex].allAddress.push(address);
             } 

        },
        /**
         * Render My Custom Component 
         */
        createRendererMyComponent: function() {
              var rendererTemplate, templateData, rendererComponent;

              rendererTemplate = utils.extend({}, mydefaultRendererTemplate);

              templateData = {
                    parentName: this.name,
                    name: 'shipping-addressall-dropdown'
                };

              rendererComponent = utils.template(rendererTemplate, templateData);               
              this.selectedItem = ko.observable(); 

              this.selectedItem.subscribe(function(latest){
                  selectShippingAddressAction(latest);
                  checkoutData.setSelectedShippingAddress(latest,latest.getKey());
                  this.createNewRendererComponent(latest,0);
                  },this);

              utils.extend(rendererComponent, {
                    allAddress: ko.observableArray( this.myAddressList),
                    selectedItem: this.selectedItem,



                });  

             layout([rendererComponent]);                
             this.rendererComponents[this.myComponentRendererIndex] = rendererComponent;


        },
        /**
         * Create new component that will render given address in the address list
         *
         * @param {Object} address
         * @param {*} index
         */
        createRendererComponent: function (address, index) {
            var rendererTemplate, templateData, rendererComponent;

            if (index in this.rendererComponents) {
                this.rendererComponents[index].address(address);
            } else {
                // rendererTemplates are provided via layout
                rendererTemplate = address.getType() != undefined && this.rendererTemplates[address.getType()] != undefined ? //eslint-disable-line
                    utils.extend({}, defaultRendererTemplate, this.rendererTemplates[address.getType()]) :
                    defaultRendererTemplate;
                templateData = {
                    parentName: this.name,
                    name: index
                };
                rendererComponent = utils.template(rendererTemplate, templateData);
                utils.extend(rendererComponent, {
                    address: ko.observable(address)
                });
                layout([rendererComponent]);
                this.rendererComponents[index] = rendererComponent;
            }
        },
        createNewRendererComponent: function (address, index) {
            var rendererTemplate, templateData, rendererComponent;
            if (index in this.rendererComponents) {
                this.rendererComponents[index].address(address);
            } else {
                // rendererTemplates are provided via layout
                rendererTemplate = address.getType() != undefined && this.rendererTemplates[address.getType()] != undefined ? //eslint-disable-line
                    utils.extend({}, defaultRendererTemplate, this.rendererTemplates[address.getType()]) :
                    defaultRendererTemplate;
                templateData = {
                    parentName: this.name,
                    name: index
                };
                rendererComponent = utils.template(rendererTemplate, templateData);
                utils.extend(rendererComponent, {
                    address: ko.observable(address)
                });
                layout([rendererComponent]);
                this.rendererComponents[index] = rendererComponent;
            }
        },

    });
  }
  else{
    var defaultRendererTemplate = {
        parent: '${ $.$data.parentName }',
        name: '${ $.$data.name }',
        component: 'Magento_Checkout/js/view/shipping-address/address-renderer/default'
    };
    return Component.extend({
        defaults: {
            template: 'Magento_Checkout/shipping-address/list',
            visible: addressList().length > 0,
            rendererTemplates: []
        },

        /** @inheritdoc */
        initialize: function () {
            this._super()
                .initChildren();

            addressList.subscribe(function (changes) {
                    var self = this;

                    changes.forEach(function (change) {
                        if (change.status === 'added') {
                            self.createRendererComponent(change.value, change.index);
                        }
                    });
                },
                this,
                'arrayChange'
            );

            return this;
        },

        /** @inheritdoc */
        initConfig: function () {
            this._super();
            // the list of child components that are responsible for address rendering
            this.rendererComponents = [];

            return this;
        },

        /** @inheritdoc */
        initChildren: function () {
            _.each(addressList(), this.createRendererComponent, this);

            return this;
        },

        /**
         * Create new component that will render given address in the address list
         *
         * @param {Object} address
         * @param {*} index
         */
        createRendererComponent: function (address, index) {
            var rendererTemplate, templateData, rendererComponent;

            if (index in this.rendererComponents) {
                this.rendererComponents[index].address(address);
            } else {
                // rendererTemplates are provided via layout
                rendererTemplate = address.getType() != undefined && this.rendererTemplates[address.getType()] != undefined ? //eslint-disable-line
                    utils.extend({}, defaultRendererTemplate, this.rendererTemplates[address.getType()]) :
                    defaultRendererTemplate;
                templateData = {
                    parentName: this.name,
                    name: index
                };
                rendererComponent = utils.template(rendererTemplate, templateData);
                utils.extend(rendererComponent, {
                    address: ko.observable(address)
                });
                layout([rendererComponent]);
                this.rendererComponents[index] = rendererComponent;
            }
        }
    });
  }
});