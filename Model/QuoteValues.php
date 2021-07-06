<?php
namespace Printq\CheckoutFields\Model;
class QuoteValues extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'printq_checkoutfields_customfield_quote_values';

	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\ResourceModel\QuoteValues');
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