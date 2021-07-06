<?php
namespace Printq\NewFields\Model;
class NewCustomTableFields extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'printq_new_field_2';

	protected function _construct()
	{
		$this->_init('Printq\NewFields\Model\ResourceModel\NewCustomTableFields');
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