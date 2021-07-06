<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\SoftDrink;

use Magento\Framework\App\Request\DataPersistorInterface;
use Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $loadedData;

    protected $dataPersistor;

    protected $collection;

    protected $storeManagerInterface;

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
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManagerInterface = $storeManagerInterface;
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
            $this->loadedData[$model->getId()] = $model->getData();
            if ($model->getImage_thumbnail()) {
                $m['image_thumbnail'][0]['name'] = $model->getImage_thumbnail();
                $m['image_thumbnail'][0]['url'] = $this->getMediaUrl() . $model->getImage_thumbnail();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }
            if ($model->getImage_print()) {
                $m['image_print'][0]['name'] = $model->getImage_print();
                $m['image_print'][0]['url'] = $this->getMediaUrl() . $model->getImage_print();
                $fullData = $this->loadedData;
                $this->loadedData[$model->getId()] = array_merge($fullData[$model->getId()], $m);
            }
        }
        $data = $this->dataPersistor->get('printq_storelocationsmanagement_softdrink');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('printq_storelocationsmanagement_softdrink');
        }
        
        return $this->loadedData;
    }
    public function getMediaUrl()
    {
        $currentStore = $this->storeManagerInterface->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'printq/feature/';
        return $mediaUrl;
    }
}

