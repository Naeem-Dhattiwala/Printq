<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\StoreLocations;

use Magento\Framework\App\Request\DataPersistorInterface;
use Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;
    protected $dataPersistor;

    protected $collection;


    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
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
        foreach ($items as $model) {
            $data = $model->getData();
            $data['products'] = explode(',', $data['products']);
            $data['soft_drink'] = explode(',', $data['soft_drink']);
            $result['general'] = $data;
            $this->loadedData[$model->getId()] = $data;
        }
        $data = $this->dataPersistor->get('printq_storelocationsmanagement_storelocations');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('printq_storelocationsmanagement_storelocations');
        }
        
        return $this->loadedData;
    }
}

