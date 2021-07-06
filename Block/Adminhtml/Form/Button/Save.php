<?php
    /**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Printq\Core\Block\Adminhtml\Form\Button;

    /**
     * Class SaveButton
     *
     * @package Magento\Customer\Block\Adminhtml\Edit
     */
    class Save extends Generic {

        /**
         * @return array
         */
        public function getButtonData() {
            return [
                'label'          => __( 'Save' ),
                'class'          => 'save primary',
                'data_attribute' => [
                    'mage-init' => [ 'button' => [ 'event' => 'save' ] ],
                    'form-role' => 'save',
                ],
                'sort_order'     => 90,
            ];
        }
    }
