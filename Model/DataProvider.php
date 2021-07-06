<?php

namespace Printq\NewFields\Model;

use Printq\NewFields\Model\ResourceModel\NewFields\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
	 public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $newfieldCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $newfieldCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
	public function getData()
	{
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
	}
	public function addFilter(\Magento\Framework\Api\Filter $filter)
	{
	    return null;
	}
}