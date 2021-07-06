<?php
namespace Printq\CheckoutFields\Model;
class CustomFieldLabel extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'printq_custom_checkout_field_label';

	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\ResourceModel\CustomFieldLabel');
	}

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function loadByMultiple($fields)
    {
        $collection = $this->getCollection();

        foreach ($fields as $key => $value) {
            $collection = $collection->addFieldToFilter($key, $value);
        }
        
        if ($collection->getFirstItem()) {
            return $collection->getFirstItem();
        } else {
            return $this;
        }
    }
}