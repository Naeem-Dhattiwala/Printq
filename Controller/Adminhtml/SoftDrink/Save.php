<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Controller\Adminhtml\SoftDrink;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    protected $softdrinkfactory;

    protected $image_thumbnailUploader;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Printq\StoreLocationsManagement\Model\SoftDrinkFactory $softdrinkfactory,
        \Printq\StoreLocationsManagement\Model\ImageUploader $image_thumbnailUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->softdrinkfactory = $softdrinkfactory;
        $this->image_thumbnailUploader = $image_thumbnailUploader;
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
            $id = $this->getRequest()->getParam('softdrink_id');
        
            $model = $this->softdrinkfactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Softdrink no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            if (isset($data['image_thumbnail'][0]['name']) && isset($data['image_thumbnail'][0]['tmp_name'])) {
                $data['image_thumbnail'] = $data['image_thumbnail'][0]['name'];
                $this->image_thumbnailUploader->moveFileFromTmp($data['image_thumbnail']);
            } elseif (isset($data['image_thumbnail'][0]['name']) && !isset($data['image_thumbnail'][0]['tmp_name'])) {
                $data['image_thumbnail'] = $data['image_thumbnail'][0]['name'];
            } else {
                $data['image_thumbnail'] = '';
            }

            if (isset($data['image_print'][0]['name']) && isset($data['image_print'][0]['tmp_name'])) {
                $data['image_print'] = $data['image_print'][0]['name'];
                $this->image_thumbnailUploader->moveFileFromTmp($data['image_print']);
            } elseif (isset($data['image_print'][0]['name']) && !isset($data['image_print'][0]['tmp_name'])) {
                $data['image_print'] = $data['image_print'][0]['name'];
            } else {
                $data['image_print'] = '';
            }
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the Softdrink.'));
                $this->dataPersistor->clear('printq_storelocationsmanagement_softdrink');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['softdrink_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Softdrink.'));
            }
        
            $this->dataPersistor->set('printq_storelocationsmanagement_softdrink', $data);
            return $resultRedirect->setPath('*/*/edit', ['softdrink_id' => $this->getRequest()->getParam('softdrink_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

