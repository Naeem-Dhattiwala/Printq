<?php
declare(strict_types=1);

namespace Printq\NewFields\Controller\Adminhtml\Index;

use Magento\Framework\Exception\LocalizedException;
use Printq\NewFields\Model\NewCustomTableFieldsFactory;

class EditInline extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    protected $newCustomTableFieldsFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Printq\NewFields\Model\NewFields $newFields
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        NewCustomTableFieldsFactory $newCustomTableFieldsFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->newCustomTableFieldsFactory = $newCustomTableFieldsFactory;
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
            
            $model = $this->newCustomTableFieldsFactory->create()->load($id);
            $order_id = $model->getOrder_id();
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Printq Edit Field no longer exists.'));
                return $resultRedirect->setPath('sales/order/view/order_id/'.$order_id);
            }
        
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Printq Edit Field.'));
                $this->dataPersistor->clear('printq_newfields_printq_editinline_field');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('sales/order/view/order_id/'.$order_id);
                }
                return $resultRedirect->setPath('sales/order/view/order_id/'.$order_id);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Printq Edit Field.'));
            }
        
            $this->dataPersistor->set('printq_newfields_printq_editinline_field', $data);
            return $resultRedirect->setPath('sales/order/view/order_id/'.$order_id);
        }
        return $resultRedirect->setPath('sales/order/view/order_id/'.$order_id);
    }
}

