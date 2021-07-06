<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model;

use Magento\Framework\Api\DataObjectHelper;
use Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface;
use Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterfaceFactory;

class SoftDrink extends \Magento\Framework\Model\AbstractModel
{

    protected $_eventPrefix = 'printq_storelocationsmanagement_softdrink';
    protected $dataObjectHelper;

    protected $softdrinkDataFactory;


    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param SoftDrinkInterfaceFactory $softdrinkDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param \Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink $resource
     * @param \Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        SoftDrinkInterfaceFactory $softdrinkDataFactory,
        DataObjectHelper $dataObjectHelper,
        \Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink $resource,
        \Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink\Collection $resourceCollection,
        array $data = []
    ) {
        $this->softdrinkDataFactory = $softdrinkDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve softdrink model with softdrink data
     * @return SoftDrinkInterface
     */
    public function getDataModel()
    {
        $softdrinkData = $this->getData();
        
        $softdrinkDataObject = $this->softdrinkDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $softdrinkDataObject,
            $softdrinkData,
            SoftDrinkInterface::class
        );
        
        return $softdrinkDataObject;
    }
}

