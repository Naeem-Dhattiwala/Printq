<?php
declare(strict_types=1);

namespace Printq\NewFields\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Printq\NewFields\Model\NewFieldsFactory;

class Back extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    protected $newFieldsFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Printq\NewFields\Model\NewFields $newFields
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        NewFieldsFactory $newFieldsFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->newFieldsFactory = $newFieldsFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        $model = $this->newFieldsFactory->create()->load($id);
        if ($model->getOrderId()) {
            return $resultRedirect->setPath('sales/order/view/order_id/'.$model->getOrderId());
        }else{
            return $resultRedirect->setPath('*/*/');
        }
        
    }
}

