<?php
namespace Printq\CustomAddress\Plugin\Checkout\Model\Checkout;

class LayoutProcessor
{
	protected $addressFactory;

	protected $_customerSession;

    protected $_dataHelper;

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array $jsLayout
     * @return array
     */
    public function __construct(
    	\Printq\CustomAddress\Model\AddressFactory $addressFactory,
    	\Magento\Customer\Model\Session $customerSession,
        \Printq\CustomAddress\Helper\Data $dataHelper
    ) {
        $this->_dataHelper = $dataHelper;
    	$this->addressFactory = $addressFactory;
    	$this->_customerSession = $customerSession;
    }

    public function getGroupId(){
		if($this->_customerSession->isLoggedIn()):
	        return $customerGroup = $this->_customerSession->getCustomer()->getGroupId();
	    endif;
	}

    public function getOptions($addDefault = true)
    {
        $options = [];
        $customOptions = $this->addressFactory->create();
        $collection = $customOptions->getCollection()
        			   ->addFieldToFilter('customer_group', $this->getGroupId());
        if ($addDefault) {
            $options = [
                [
                    'value' => '',
                    'label' => 'Please Select',
                ]
            ];
        }
        foreach ($collection as $option) {
            $options[] = [
                'value' => $option->getAddress_id(),
                'label' => $option->getName(),
            ];
        }
        return $options;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {
        $optionsvalue = '';
        if ($this->_dataHelper->isEnabled() == 1) {
            $optionsvalue = [
                'component' => 'Magento_Ui/js/form/element/select',
                'config' => [
                    'customScope' => 'shippingAddress',
                    'template' => 'ui/form/field',
                    'elementTmpl' => 'ui/form/element/select',
                    'id' => 'manage_address',
                ],
                'dataScope' => 'shippingAddress.custom_address_name',
                'label' => 'Manage Address Dropdown',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 0,
                'id' => 'manage_address',
                'options' => $this->getOptions(),
                'value' => 0,
            ];
        }
    	$jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['drop_down'] = $optionsvalue;

        return $jsLayout;
    }
}
?>