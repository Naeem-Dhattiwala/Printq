<?php
/**
 *
 * @author        Krunal Padmashali <kp@cloudlab.at>.
 * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
 * @link          https://cloudlab.ag/
 * @date          07/01/2021
 */
namespace Printq\CheckoutFields\Controller\Adminhtml\CheckoutFields;

use Magento\Backend\App\Action;
use Printq\CheckoutFields\Model\CustomField;
 
class Delete extends Action
{
	public function execute()
    {
        $field_id = $this->getRequest()->getParam('id');
        if (!$field_id) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        if (
        	$customField = $this->_objectManager->create(CustomField::class)->load($field_id)
        ) {
            $customField->delete();
        }

        $this->messageManager->addSuccess(__('Custom field have been deleted.'));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}