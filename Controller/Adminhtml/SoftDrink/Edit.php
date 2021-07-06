<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Controller\Adminhtml\SoftDrink;

class Edit extends \Printq\StoreLocationsManagement\Controller\Adminhtml\SoftDrink
{

    protected $resultPageFactory;

    protected $softdrinkfactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Printq\StoreLocationsManagement\Model\SoftDrinkFactory $softdrinkfactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->softdrinkfactory = $softdrinkfactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('softdrink_id');
        $model = $this->softdrinkfactory->create();
        
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This Softdrink no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->_coreRegistry->register('printq_storelocationsmanagement_softdrink', $model);
        
        // 3. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Softdrink') : __('New Softdrink'),
            $id ? __('Edit Softdrink') : __('New Softdrink')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Soft Drinks'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Edit Soft Drinks', $model->getId()) : __('New Soft Drinks'));
        return $resultPage;
    }
}

