<?php
namespace Printq\CheckoutFields\Model\Config\Source;

class Positions implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    protected $options;

    const LOCATION_SHIPPING = 1;

    const LOCATION_BILLING = 2;

    const LOCATION_REVIEW = 3;

    const LOCATION_PAYMENT = 4;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        if (null == $this->options) {
            $this->options = [
            	['value' => self::LOCATION_SHIPPING, 'label' => __('Shipping')],
            	['value' => self::LOCATION_PAYMENT, 'label' => __('Payment')],
            ];
        }

        return $this->options;
    }
}
