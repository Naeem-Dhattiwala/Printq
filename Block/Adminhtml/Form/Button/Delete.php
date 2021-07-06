<?php
    /**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Printq\Core\Block\Adminhtml\Form\Button;

    /**
     * Class Delete
     */
    class Delete extends Generic {

        /**
         * @return array
         */
        public function getButtonData() {
            $data = [];
            if( $this->getObjectId() ) {
                $data = [
                    'label'      => __( 'Delete' ),
                    'class'      => 'delete',
                    'on_click'   => 'deleteConfirm(\'' . __(
                            'Are you sure you want to do this?'
                        ) . '\', \'' . $this->getDeleteUrl() . '\')',
                    'sort_order' => 20,
                ];
            }

            return $data;
        }

        /**
         * @return string
         */
        public function getDeleteUrl() {
            return $this->getUrl( '*/*/delete', [ 'id' => $this->getObjectId() ] );
        }
    }
