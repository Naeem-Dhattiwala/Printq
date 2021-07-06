<?php

namespace Printq\StoreLocationsManagement\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Status implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
            0 => [
                'label' => 'Enable',
                'value' => 'enable'
            ],
            1 => [
                'label' => 'Disbale',
                'value' => 'disable'
            ],
        ];

        return $options;
    }
}
?>