<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Controller\Adminhtml\StoreLocations;

class Delete extends \Printq\StoreLocationsManagement\Controller\Adminhtml\StoreLocations
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('storelocations_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Printq\StoreLocationsManagement\Model\StoreLocations::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Storelocations.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['storelocations_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Storelocations to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

