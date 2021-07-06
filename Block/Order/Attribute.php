<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
declare(strict_types=1);

namespace Printq\CheckoutFields\Block\Order;

use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Printq\CheckoutFields\Model\QuoteValues;
use Printq\CheckoutFields\Model\OrderValues;
use Printq\CheckoutFields\Model\CustomField;
use Printq\CheckoutFields\Model\CustomFieldOptions;
use Printq\CheckoutFields\Model\CustomFieldLabel;

class Attribute extends Template
{
    protected $orderFactory;

    protected $quotevaluecollection;

    protected $ordervaluecollection;

    protected $customfieldcollection;

    protected $customfieldoptioncollection;

    protected $customfieldlabelcollection;

    protected $storeManagerInterface;

    protected $_template = 'order\view\printq_attribute.phtml';

    /*protected $_web = 'template/image-preview.html';*/

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        QuoteValues $quotevaluecollection,
        OrderValues $ordervaluecollection,
        CustomField $customfieldcollection,
        CustomFieldOptions $customfieldoptioncollection,
        CustomFieldLabel $customfieldlabelcollection,
        StoreManagerInterface $storeManagerInterface,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->orderFactory = $orderFactory;
        $this->quotevaluecollection = $quotevaluecollection;
        $this->ordervaluecollection = $ordervaluecollection;
        $this->customfieldcollection = $customfieldcollection;
        $this->customfieldoptioncollection = $customfieldoptioncollection;
        $this->customfieldlabelcollection = $customfieldlabelcollection;
        $this->storeManagerInterface = $storeManagerInterface;
        parent::__construct($context, $data);
    }
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }
    public function getAttributeValue()
    {

        $orderId = $this->getOrder()->getEntityId();
        $ordervaluecollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId]);
        $customData=[];
        $customDatacollection=[];
        foreach ($ordervaluecollection as $value) {
            $Field_id = $value->getField_id();
            $customfieldcollection = $this->customfieldcollection->getCollection()
                                    ->addFieldToFilter('field_id',['eq' => $Field_id])
                                    ->addFieldToFilter('in_customer_order_view',['eq' => 1]);
            if($customfieldcollection){
                foreach ($customfieldcollection as $customfieldcollectionvalue) {
                    $customData[] = $customfieldcollectionvalue->getfield_id();
                    $customDatacollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId])
                                ->addFieldToFilter('field_id',['in' => $customData]);
                }
            }
        }
        return $customDatacollection;
    }
    public function getAttributeLabel()
    {
        $orderId = $this->getOrder()->getEntityId();
        $ordervaluecollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId]);
        foreach ($ordervaluecollection as $value) {
            $Field_id[] = $value->getField_id();
            $customfieldlabelcollection = $this->customfieldlabelcollection->getCollection()
                                          ->addFieldToFilter('field_id',['in' => $Field_id])
                                          ->addFieldToFilter('store_id',['eq' => $this->getStoreId()]);
            foreach ($customfieldlabelcollection as $customfieldlabelcollectionvalue) {
                $Field_id2[] = $customfieldlabelcollectionvalue->getField_id();
                $customfieldcollection = $this->customfieldcollection->getCollection()
                                    ->addFieldToFilter('field_id',['in' => $Field_id])
                                    ->addFieldToFilter('field_id',['nin' => $Field_id2]);
            }
        }
        return $customfieldcollection;
    }
    public function getAttributeDefaultLabel()
    {
        $orderId = $this->getOrder()->getEntityId();
        $ordervaluecollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId]);
        foreach ($ordervaluecollection as $value) {
            $Field_id[] = $value->getField_id();
            $customfieldlabelcollection = $this->customfieldlabelcollection->getCollection()
                                          ->addFieldToFilter('field_id',['in' => $Field_id])
                                           ->addFieldToFilter('store_id',['eq' => $this->getStoreId()]);
        }
        return $customfieldlabelcollection;
    }
    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }
    public function getOrderIncrementId()
    {
        return $this->getOrder()->getIncrementId();
    }
    public function getStoreId()
    {
        return $this->storeManagerInterface->getStore()->getId();
    }
}
