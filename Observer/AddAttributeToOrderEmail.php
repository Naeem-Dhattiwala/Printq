<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Printq\CheckoutFields\Model\QuoteValues;
use Printq\CheckoutFields\Model\OrderValues;
use Printq\CheckoutFields\Model\CustomField;
use Printq\CheckoutFields\Model\CustomFieldOptions;
use Printq\CheckoutFields\Model\CustomFieldLabel;


class AddAttributeToOrderEmail implements ObserverInterface
{
	protected $orderFactory;

    protected $quotevaluecollection;

    protected $ordervaluecollection;

    protected $customfieldcollection;

    protected $customfieldoptioncollection;

    protected $customfieldlabelcollection;

    protected $storeManagerInterface;

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
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $transport = $observer->getTransport();
        $order = $transport->getOrder();
        $orderId = $order->getId();
        $ordervaluecollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId]);
        $customData=[];
        $customDatacollection=[];
        foreach ($ordervaluecollection as $value) {
            $Field_id = $value->getField_id();
            $customfieldcollection = $this->customfieldcollection->getCollection()
                                    ->addFieldToFilter('field_id',['eq' => $Field_id])
                                    ->addFieldToFilter('in_order_conf_email',['eq' => 1]);
            if($customfieldcollection){
                foreach ($customfieldcollection as $customfieldcollectionvalue) {
                    $customData[] = $customfieldcollectionvalue->getfield_id();
                    $customDatacollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId])
                                ->addFieldToFilter('field_id',['in' => $customData]);

                }
            }
        }
        $orderlabelcollection = $this->ordervaluecollection->getCollection()
                                ->addFieldToFilter('order_id',['eq' => $orderId]);
        foreach ($orderlabelcollection as $labelvalue) {
            $Field_id2[] = $labelvalue->getField_id();
            $customlabelfieldcollection = $this->customfieldcollection->getCollection()
                                    ->addFieldToFilter('field_id',['in' => $Field_id2]);
        }


        foreach ($customDatacollection as $collectionvalue) {
            foreach ($customlabelfieldcollection as $collectionlabel) {
                if ($collectionlabel->getField_id() == $collectionvalue->getField_id()) {
                    $transport['printq_order_variable'] .= '<strong>' . $collectionlabel->getFrontend_label() . ' ' . ':' . ' ' . '</strong>' . $collectionvalue->getValue() . '<br>';
                }
            }
        }
    }
}