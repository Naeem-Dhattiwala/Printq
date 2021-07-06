<?php
namespace Printq\CheckoutFields\Model;


class CustomField extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
	const CACHE_TAG = 'printq_checkoutfields_customfield';

	protected $_cacheTag = 'printq_checkoutfields_customfield';

	protected $_eventPrefix = 'printq_checkoutfields_customfield';

	protected function _construct()
	{
		$this->_init('Printq\CheckoutFields\Model\ResourceModel\CustomField');
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

	/**
     * Return array of labels of stores
     *
     * @return string[]
     */
    public function getStoreLabels()
    {
        if (!$this->getData('store_labels')) {
            $storeLabel = $this->getResource()->getStoreLabelsByFieldId($this->getId());
            $this->setData('store_labels', $storeLabel);
        }
        return $this->getData('store_labels');
    }

    /**
     * Return store label of field
     *
     * @param int|null $storeId
     * @return string
     */
    public function getStoreLabel($storeId = null)
    {
        if ($this->hasData('store_label')) {
            return $this->getData('store_label');
        }
        $labels = $this->getStoreLabels();
        if (isset($labels[$storeId])) {
            return $labels[$storeId];
        } else {
            return $this->getFrontendLabel();
        }
    }
}
