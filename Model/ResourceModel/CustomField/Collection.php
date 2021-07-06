<?php
namespace Printq\CheckoutFields\Model\ResourceModel\CustomField;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'field_id';
	protected $_eventPrefix = 'printq_checkoutfields_customfield_collection';
	protected $_eventObject = 'customfield_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\CustomField', 'Printq\CheckoutFields\Model\ResourceModel\CustomField');
	}

}