<?php
namespace Printq\NewFields\Block\Adminhtml\Order;

class Index extends \Magento\Backend\Block\Template
{
    protected $orderInterface;

    protected $newFields;

    protected $newCustomTableFields;
 
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Sales\Api\Data\OrderInterface $orderInterface,
        \Printq\NewFields\Model\NewFields $newFields,
        \Printq\NewFields\Model\NewCustomTableFields $newCustomTableFields,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->orderInterface = $orderInterface;
        $this->newFields = $newFields;
        $this->newCustomTableFields = $newCustomTableFields;
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
    public function getFormAction()
    {
        return $this->getUrl('printq_newfields/index/editinline/', ['_secure' => true]);
    }
     public function getEditAction()
    {
        return $this->getUrl('printq_newfields/index/edit', ['_secure' => true]);
    }
    public function getQuoteEditAction()
    {
        return $this->getUrl('printq_newfields/index/savequoteitems', ['_secure' => true]);
    }
     public function getFormKey()
    {
         return $this->formKey->getFormKey();
    }
    public function getProductName(){
        $order = $this->orderInterface->load($this->getOrderId());    
        $orderItems = $order->getAllItems(); 
        return $orderItems;
    }
    public function getnewFields()
    {
        $Collection = $this->newFields->getCollection()
                      ->addFieldToFilter('order_id', ['in' => $this->getOrderId()]);
        if ($Collection) {
            return $Collection;
        }else{
            return;
        }
    }
    public function getnewCustomTableFields(){
       $Collection = $this->newCustomTableFields->getCollection()
                      ->addFieldToFilter('order_id', ['in' => $this->getOrderId()]);
        if ($Collection) {
            return $Collection;
        }else{
            return;
        } 
    }
}