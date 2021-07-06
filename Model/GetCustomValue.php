<?php

namespace Printq\CheckoutFields\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class GetCustomValue implements ConfigProviderInterface
{
    protected $_customFieldFactory;

    public function __construct(
        \Printq\CheckoutFields\Model\CustomField $customFieldFactory
    ) {
        $this->_customFieldFactory = $customFieldFactory;
    }
    public function getConfig()
    {
        $payment_field = $this->_customFieldFactory->getCollection()
                        ->addFieldToFilter('position',['eq' => 4]);
        $config = [];
        $field_data = '';
        foreach ($payment_field as $value){
            if($value->getStatus() == 1){
                $field_data .= $value->getField_code().',';
            }
        }
        $config['name'] = $field_data;
        return $config;
    }
}
