<?php
    /**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Printq\Core\Block\Adminhtml\Form\Button;

    /**
     * Class SaveAndContinueButton
     */
    class SaveAndContinue extends Generic {

        /**
         * @return array
         */
        public function getButtonData() {
            return [
                'label'          => __( 'Save and Continue Edit' ),
                'class'          => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [ 'event' => 'saveAndContinueEdit' ],
                    ],
                ],
                'sort_order'     => 80,
            ];
        }
    }
