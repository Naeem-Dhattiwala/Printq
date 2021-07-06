<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Printq\PaymentMethods\Model\Config\Source;

/**
 * @api
 * @since 100.0.2
 */
class Openpaid implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [['value' => 1, 'label' => __('Open')], ['value' => 2, 'label' => __('Paid')]];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [1 => __('Open'), 2 => __('Paid')];
    }
}
