<?php
namespace Printq\CheckoutFields\Model\ResourceModel;

use \Magento\Framework\Model\AbstractModel;

class CustomFieldLabel extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
	{
		$this->_init('printq_custom_checkout_field_label', 'field_label_id');
	}
}