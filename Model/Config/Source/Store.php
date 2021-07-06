<?php
    /**
     * Created by PhpStorm.
     * User: th
     * Date: 3 Nov 2016
     * Time: 11:54
     */

    namespace Printq\Core\Model\Config\Source;

    use Magento\Framework\Option\ArrayInterface;

    class Store implements ArrayInterface {

        /**
         * @return array
         */
        public function toOptionArray() {

            return [
                [ 'value' => 1, 'label' => __( 'Global' ) ],
                [ 'value' => 2, 'label' => __( 'Per Website' ) ]
            ];
        }

    }