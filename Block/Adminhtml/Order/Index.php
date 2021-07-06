<?php
namespace Printq\Lastschrift\Block\Adminhtml\Order;

class Index extends \Magento\Backend\Block\Template
{
    protected $orderInterface;

    protected $_paymentCollectionFactory;
 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Model\ResourceModel\Order\Payment\CollectionFactory $paymentCollectionFactory,
        \Magento\Sales\Api\Data\OrderInterface $orderInterface,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->orderInterface = $orderInterface;
        $this->_paymentCollectionFactory = $paymentCollectionFactory;
        parent::__construct($context, $data);
    }
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }
    public function getOrderId()
    {
        return $this->getOrder()->getEntityId();
    }
    public function getPaymentExtraInformation(){
        $collection = $this->_paymentCollectionFactory->create()->addFieldToFilter('parent_id', ['eq' => $this->getOrderId()])->addFieldToFilter('additional_information', ['eq' => '{"method_title":"Lastschrift"}'])->addFieldToSelect('*');
        return $collection;
    }
}