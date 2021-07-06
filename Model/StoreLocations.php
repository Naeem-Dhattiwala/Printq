<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model;

use Magento\Framework\Api\DataObjectHelper;
use Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface;
use Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterfaceFactory;

class StoreLocations extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'printq_storelocationsmanagement_storelocations';
    protected $dataObjectHelper;

    protected $storelocationsDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param StoreLocationsInterfaceFactory $storelocationsDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations $resource
     * @param \Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        StoreLocationsInterfaceFactory $storelocationsDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations $resource,
        \Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations\Collection $resourceCollection,
        array $data = []
    ) {
        $this->storelocationsDataFactory = $storelocationsDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve storelocations model with storelocations data
     * @return StoreLocationsInterface
     */
    public function getDataModel()
    {
        $storelocationsData = $this->getData();
        
        $storelocationsDataObject = $this->storelocationsDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $storelocationsDataObject,
            $storelocationsData,
            StoreLocationsInterface::class
        );
        
        return $storelocationsDataObject;
    }
}

