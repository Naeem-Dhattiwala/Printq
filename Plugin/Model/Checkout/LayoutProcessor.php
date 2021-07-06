<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Plugin\Model\Checkout;

use Printq\CheckoutFields\Model\Config\Source\InputTypes;
use Printq\CheckoutFields\Model\Config\Source\Positions;
use Printq\CheckoutFields\Model\CustomField;
use Printq\CheckoutFields\Model\ResourceModel\CustomField\CollectionFactory;
use Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions\CollectionFactory as OptionsCollectionFactory;

class LayoutProcessor
{
    /**
     * @var CollectionFactory
     */
    public $customFieldCollectionFactory;

    /**
     * @var OptionsCollectionFactory
     */
    protected $_customFieldOptionCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    protected $_dataHelper;

    protected $customerSession;

    /**
     * @param CollectionFactory     $customFieldCollectionFactory
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        CollectionFactory $customFieldCollectionFactory,
        OptionsCollectionFactory $customFieldOptionCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Printq\CheckoutFields\Helper\Data $dataHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
    {
        $this->_storeManager                       = $storeManager;
        $this->_dataHelper                         = $dataHelper;
        $this->_customFieldOptionCollectionFactory = $customFieldOptionCollectionFactory;
        $this->customFieldCollectionFactory        = $customFieldCollectionFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param array                                            $jsLayout
     *
     * @return array
     */
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array $jsLayout
    )
    {
        $this->addShippingFields($jsLayout);
        $this->addPaymentFields($jsLayout);

        return $jsLayout;
    }

    public function addShippingFields(&$jsLayout)
    {
        $customFields = $this->getCustomFields(Positions::LOCATION_SHIPPING);

        $shippingFields = $this->getFieldsArray($customFields, 'shipping');

        if (!$shippingFields) {
            return;
        }
        if ($this->_dataHelper->isEnabled() != 1) {
            return;
        }
        if($this->customerSession->isLoggedIn()){
            $customer = $this->customerSession->getCustomer();
            $shippingAddress = $customer->getDefaultShippingAddress();
            if($shippingAddress){
                $existingFields = $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['before-form']['children'];

                $shippingFields = array_merge($existingFields, $shippingFields);

                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['before-form']['children'] = $shippingFields;
            }else{
                $existingFields = $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];

                $shippingFields = array_merge($existingFields, $shippingFields);

                $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'] = $shippingFields;
            }
        }else{

            $existingFields = $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'];

            $shippingFields = array_merge($existingFields, $shippingFields);

            $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
            ['shippingAddress']['children']['shipping-address-fieldset']['children'] = $shippingFields;
        }
        return $jsLayout;
    }

    public function getCustomFields($position)
    {
        if ($this->_dataHelper->isEnabled() != 1) {
            return;
        }
        $customFields = $this->customFieldCollectionFactory->create()
                                                           ->addFieldToFilter('status',
                                                                              ['eq' => true]
                                                           )->addFieldToFilter('position',
                                                                               ['eq' => $position]
            )->setOrder('sort_order', 'asc');

        return $customFields;
    }

    public function getFieldsArray($customFields, $customScope)
    {
        if ($this->_dataHelper->isEnabled() != 1) {
            return;
        }
        $fieldsArray = [];

        foreach ($customFields as $customField) {
            $multiple = false;
            switch ($customField->getInputType()) {
                case InputTypes::TYPE_TEXT:
                    $component   = 'Magento_Ui/js/form/element/abstract';
                    $elementTmpl = 'ui/form/element/input';
                    $options     = [];
                    break;
                case InputTypes::TYPE_TEXTAREA:
                    $component   = 'Magento_Ui/js/form/element/textarea';
                    $elementTmpl = 'ui/form/element/textarea';
                    $options     = [];
                    break;
                case InputTypes::TYPE_RADIO:
                    $component   = 'Magento_Ui/js/form/element/checkbox-set';
                    $elementTmpl = 'Printq_CheckoutFields/form/element/radios';
                    $options     = $this->getOptions($customField, false);
                    break;
                case InputTypes::TYPE_SELECT:
                    $component   = 'Magento_Ui/js/form/element/select';
                    $elementTmpl = 'ui/form/element/select';
                    $options     = $this->getOptions($customField);
                    break;
                case InputTypes::TYPE_CHECKBOX:
                    $component   = 'Magento_Ui/js/form/element/checkbox-set';
                    $elementTmpl = 'Printq_CheckoutFields/form/element/checkboxes';
                    $options     = $this->getOptions($customField, false);
                    $multiple    = true;
                    break;
                default:
                    $component   = 'Magento_Ui/js/form/element/multiselect';
                    $elementTmpl = 'ui/form/element/multiselect';
                    $options     = $this->getOptions($customField);
                    break;
            }

            $fieldCode = $customField->getFieldCode();

            $fieldsArray[$fieldCode] = [
                'component'   => $component,
                'config'      => [
                    'template'    => 'ui/form/field',
                    'label'       => $customField->getStoreLabel($this->getStoreId()),
                    'elementTmpl' => $elementTmpl,
                    'id'          => 'printq-custom-field-' . $customScope . '-' . $fieldCode
                ],
                'customScope' => 'printqCustomFields.' . $customScope,
                'dataScope'   => 'printqCustomFields.' . $customScope . '.' . $fieldCode,
                'label'       => $customField->getStoreLabel($this->getStoreId()),
                'provider'    => 'checkoutProvider',
                'visible'     => true,
                'validation'  => [],
                'options'     => $options,
                'multiple'    => $multiple
            ];
        }

        return $fieldsArray;
    }

    public function getOptions(CustomField $customfield, $addDefault = true)
    {
        if ($this->_dataHelper->isEnabled() != 1) {
            return;
        }
        $options = [];

        if ($addDefault) {
            $options = [
                [
                    'value' => '',
                    'label' => 'Please Select',
                ]
            ];
        }

        $customOptions = $this->_getOptionValuesCollection($customfield);

        foreach ($customOptions as $option) {
            $options[] = [
                'value' => $option->getValue(),
                'label' => $option->getValue(),
            ];
        }

        return $options;
    }

    public function _getOptionValuesCollection(CustomField $customfield)
    {
        if ($this->_dataHelper->isEnabled() != 1) {
            return;
        }
        $collection = $this->_customFieldOptionCollectionFactory->create()
                                                                ->setCustomFieldFilter($customfield->getId())
                                                                ->setOrder('sort_order', 'asc');

        if ($this->getStoreId()) {
            $collection = $collection->setStoreFilter(
                $this->getStoreId(),
                true
            );
        }

        return $collection->load();
    }

    /**
     * Get store identifier
     *
     * @return  int
     */
    public function getStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    public function addPaymentFields(&$jsLayout)
    {
        $customFields = $this->getCustomFields(Positions::LOCATION_PAYMENT);

        $PaymentFields = $this->getFieldsArray($customFields, 'payment');

        if (!$PaymentFields) {
            return;
        }
        if ($this->_dataHelper->isEnabled() != 1) {
            return;
        }

        $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']
        ['children']['payment']['children']['payments-list']
        ['children']['before-place-order']['children'] = $PaymentFields;


        return $jsLayout;
    }
}
