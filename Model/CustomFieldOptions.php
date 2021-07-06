<?php
namespace Printq\CheckoutFields\Model;
class CustomFieldOptions extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'printq_checkoutfields_customfield_options';

	protected $_cacheTag = 'printq_checkoutfields_customfield_options';

	protected $_eventPrefix = 'printq_checkoutfields_customfield_options';

	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\ResourceModel\CustomFieldOptions');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];

		return $values;
	}
}