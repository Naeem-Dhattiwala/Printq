<?php

namespace Printq\CustomAddress\Plugin\Block\Checkout;

use \Magento\Checkout\Block\Checkout\LayoutProcessor as MageLayoutProcessor;
use \Printq\CustomAddress\Helper\Data as CustomAddrHelper;

class LayoutProcessor
{

    protected $_vatId = 'vat_id';

    /**
     * @var \Printq\CustomAddress\Helper\Data
     */
    protected $_addressHelper;

    public function __construct(CustomAddrHelper $addressHelper)
    {
        $this->_addressHelper = $addressHelper;
    }

    public function afterProcess(MageLayoutProcessor $subject, $jsLayout)
    {
        return $jsLayout;
        $shippingConfiguration = &$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']
                                  ['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];
        $billingConfiguration = &$jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
                                 ['children']['payment']['children']['payments-list']['children'];
        
        if (isset($billingConfiguration)) {

            foreach (
                $billingConfiguration as $key => $payment
            ) {
                $billingConfiguration[$key]['children']['form-fields']
                ['children'][$this->_vatId]['validation'] = [
                    'required-entry' => true,
                    'additionalClasses' => 'required',
                ];
            }

        }

        if ($shippingConfiguration ) {
    
//            iF($_SERVER['REMOTE_ADDR']=="79.112.51.207"){
//                echo "<PRE>";
//                print_R($shippingConfiguration[$this->_vatId]);
//                exit;
//            }
            $shippingConfiguration[$this->_vatId]['validation'] = [
                'required-entry' => true,
                'additionalClasses' => 'required',
            ];
        }

        return $jsLayout;
    }
}
