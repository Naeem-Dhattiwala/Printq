define( [
    'jquery',
    'Magento_Ui/js/modal/modal',
    'text!ui/template/modal/modal-popup.html',
    'text!ui/template/modal/modal-slide.html',
    'text!ui/template/modal/modal-custom.html'
], function( $, modal, popupTpl, slideTpl, customTpl ) {

    'use strict';

    $.widget( 'printq.modal', $.mage.modal, {
        options    : {
            type              : 'popup',
            title             : '',
            subTitle          : '',
            modalClass        : '',
            focus             : '[data-role="closeBtn"]',
            autoOpen          : false,
            clickableOverlay  : true,
            popupTpl          : popupTpl,
            slideTpl          : slideTpl,
            customTpl         : customTpl,
            modalVisibleClass : '_show',
            parentModalClass  : '_has-modal',
            innerScrollClass  : '_inner-scroll',
            responsive        : false,
            innerScroll       : false,
            modalTitle        : '[data-role="title"]',
            modalSubTitle     : '[data-role="subTitle"]',
            modalBlock        : '[data-role="modal"]',
            modalCloseBtn     : '[data-role="closeBtn"]',
            modalContent      : '[data-role="content"]',
            modalAction       : '[data-role="action"]',
            focusableScope    : '[data-role="focusable-scope"]',
            focusableStart    : '[data-role="focusable-start"]',
            focusableEnd      : '[data-role="focusable-end"]',
            appendTo          : 'body',
            wrapperClass      : 'modals-wrapper',
            overlayClass      : 'modals-overlay',
            responsiveClass   : 'modal-slide',
            trigger           : '',
            modalLeftMargin   : 45,
            closeText         : $.mage.__( 'Close' ),
            buttons           : [{
                text  : $.mage.__( 'Ok' ),
                class : '',
                attr  : {},

                /**
                 * Default action on button click
                 */
                click : function( event ) {
                    this.closeModal( event );
                }
            }],
            keyEventHandlers  : {

                /**
                 * Tab key press handler,
                 * set focus to elements
                 */
                tabKey : function() {
                    if ( document.activeElement === this.modal[0] ) {
                        this._setFocus( 'start' );
                    }
                },

                /**
                 * Escape key press handler,
                 * close modal window
                 */
                escapeKey : function() {
                    if ( this.options.isOpen && this.modal.find( document.activeElement ).length ||
                         this.options.isOpen && this.modal[0] === document.activeElement ) {
                        this.closeModal();
                    }
                }
            },
            createCallback    : null,
            openCallback      : null,
            closeCallback     : null
        },
        /**
         * Creates modal widget.
         */
        _create    : function() {
            this._super();
            if ( this.options.createCallback && $.isFunction( this.options.createCallback ) ) {
                this.options.createCallback.apply( this );
            }
        },
        /**
         * Open modal.
         * * @return {Element} - current element.
         */
        openModal  : function() {
            this._super();

            if ( this.options.openCallback && $.isFunction( this.options.openCallback ) ) {
                this.options.openCallback.apply( this );
            }

            return this.element;
        },
        /**
         * Close modal.
         * * @return {Element} - current element.
         */
        _close : function() {
            this._super();
            if ( this.options.closeCallback && $.isFunction( this.options.closeCallback ) ) {
                this.options.closeCallback.apply( this );
            }
        }
    } );

    return $.printq.modal;
} );
