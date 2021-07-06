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
use Printq\CheckoutFields\Model\QuoteValues;
use Printq\CheckoutFields\Model\OrderValuesFactory;


class SaveShippingAttributeObserver implements ObserverInterface
{
  protected $_quotevaluecollection;

  protected $_ordervalues;

  public function __construct(
    QuoteValues $quotevaluecollection,
    OrderValuesFactory $ordervalues,
    array $data = []
  ){
    $this->_quotevaluecollection = $quotevaluecollection;
    $this->_ordervalues = $ordervalues;
  }

  public function execute(\Magento\Framework\Event\Observer $observer) {
    $order = $observer->getEvent()->getOrder();
    $orderId = $order->getId();
    $collection = $this->_quotevaluecollection->getCollection()
                ->addFieldToFilter('quote_id', ['eq' => $order->getQuoteId()]);

    $orderValues_model = $this->_ordervalues->create();
    if($collection) {
      foreach ($collection as $key => $value) {
          $orderValues_model->setData(['field_id' => $value->getField_id(),'order_id' => $orderId,'value' => $value->getValue()])->save();
      }
    }
  }
}
