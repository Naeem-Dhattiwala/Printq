<?php
    /**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Printq\Core\Block\Adminhtml\Form\Button;

    /**
     * Class BackButton
     */
    class Back extends Generic {

        /**
         * @return array
         */
        public function getButtonData() {
            return [
                'label'      => __( 'Back' ),
                'on_click'   => sprintf( "location.href = '%s';", $this->getBackUrl() ),
                'class'      => 'back',
                'sort_order' => 10
            ];
        }

        /**
         * Get URL for back (reset) button
         *
         * @return string
         */
        public function getBackUrl() {
            if( $backUrl = $this->context->getRequest()->getParam( 'back_url' ) ) {
                return $backUrl;
            }

            return $this->getUrl( '*/*/' );
        }
    }
