<?php
namespace Printq\CheckoutFields\Model\ResourceModel\OrderValues;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\OrderValues', 'Printq\CheckoutFields\Model\ResourceModel\OrderValues');
	}
}