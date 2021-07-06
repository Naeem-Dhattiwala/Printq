<?php
namespace Printq\NewFields\Model\ResourceModel\NewCustomTableFields;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('Printq\NewFields\Model\NewCustomTableFields', 'Printq\NewFields\Model\ResourceModel\NewCustomTableFields');
	}
}