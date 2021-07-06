<?php
declare(strict_types=1);

namespace Printq\NewFields\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Printq\NewFields\Model\NewFieldsFactory;

class Save extends \Magento\Backend\App\Action
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
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
        
            $model = $this->newFieldsFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Printq Edit Field no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Printq Edit Field.'));
                $this->dataPersistor->clear('printq_newfields_printq_edit_field');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                return $resultRedirect->setPath('sales/order/view/order_id/'.$model->getOrderId());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Printq Edit Field.'));
            }
        
            $this->dataPersistor->set('printq_newfields_printq_edit_field', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

