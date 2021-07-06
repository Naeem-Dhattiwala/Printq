<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Controller\Adminhtml\StoreLocations;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
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
            $id = $this->getRequest()->getParam('storelocations_id');
        
            $model = $this->_objectManager->create(\Printq\StoreLocationsManagement\Model\StoreLocations::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Storelocations no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $data['products']=implode(',',$data['products']);
            $data['soft_drink']=implode(',',$data['soft_drink']);
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Storelocations.'));
                $this->dataPersistor->clear('printq_storelocationsmanagement_storelocations');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['storelocations_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Storelocations.'));
            }
        
            $this->dataPersistor->set('printq_storelocationsmanagement_storelocations', $data);
            return $resultRedirect->setPath('*/*/edit', ['storelocations_id' => $this->getRequest()->getParam('storelocations_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

