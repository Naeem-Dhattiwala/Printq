<?php
namespace Printq\CheckoutFields\Model\ResourceModel;
class CustomFieldOptions extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context
	)
	{
		parent::__construct($context);
	}
	
	protected function _construct()
	{
		$this->_init('printq_custom_checkout_field_option', 'option_id');
	}
	
}