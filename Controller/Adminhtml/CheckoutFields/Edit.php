<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Controller\Adminhtml\CheckoutFields;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
 
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\Registry registry
     * @param \Magento\Framework\View\Result\PageFactory resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->registry = $registry;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $model = $this->_objectManager->create(
            \Printq\CheckoutFields\Model\CustomField::class
        );

        if ($id) {
            $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This field no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('printq_checkoutfields/*/');
            }
        }

        $data = $this->_objectManager->get(\Magento\Backend\Model\Session::class)->getAttributeData(true);

        if (!empty($data)) {
            $model->addData($data);
        }
        $attributeData = $this->getRequest()->getParam('attribute');
        if (!empty($attributeData) && $id === null) {
            $model->addData($attributeData);
        }

        $this->registry->register('custom_field', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Checkout Fields'));
        $resultPage->getLayout()
            ->getBlock('customfields_edit_js');
        return $resultPage;
    }
}