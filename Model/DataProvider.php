<?php
namespace Printq\CheckoutFields\Model;

use Printq\CheckoutFields\Model\ResourceModel\CustomField\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $customFieldCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $customFieldCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $customFieldCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
 
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $customField) {
            $this->loadedData[$customField->getId()]['general'] = $customField->getData();
            $this->loadedData[$customField->getId()]['configuration'] = $customField->getData();
        }

        return $this->loadedData;
    }
}