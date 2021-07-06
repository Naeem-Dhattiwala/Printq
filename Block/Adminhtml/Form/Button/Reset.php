<?php
    /**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Printq\Core\Block\Adminhtml\Form\Button;

    /**
     * Class ResetButton
     */
    class Reset extends Generic {

        /**
         * @return array
         */
        public function getButtonData() {
            return [
                'label'      => __( 'Reset' ),
                'class'      => 'reset',
                'on_click'   => 'location.reload();',
                'sort_order' => 30
            ];
        }
    }
