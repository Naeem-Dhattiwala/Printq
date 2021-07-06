<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Controller\Adminhtml\SoftDrink;

class Delete extends \Printq\StoreLocationsManagement\Controller\Adminhtml\SoftDrink
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
        $id = $this->getRequest()->getParam('softdrink_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create(\Printq\StoreLocationsManagement\Model\SoftDrink::class);
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Softdrink.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['softdrink_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Softdrink to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}

