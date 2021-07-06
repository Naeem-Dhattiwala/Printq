<?php
namespace Printq\CheckoutFields\Model\ResourceModel\CustomFieldLabel;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'field_label_id';
	protected $_eventPrefix = 'printq_custom_checkout_field_label';
	protected $_eventObject = 'customfieldlabel_collection';

	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\CustomFieldLabel', 'Printq\CheckoutFields\Model\ResourceModel\CustomFieldLabel');
	}

}