<?php
namespace Printq\NewFields\Model\ResourceModel\NewFields;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Printq\NewFields\Model\NewFields', 'Printq\NewFields\Model\ResourceModel\NewFields');
	}
}