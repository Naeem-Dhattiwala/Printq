<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterfaceFactory;
use Printq\StoreLocationsManagement\Api\Data\SoftDrinkSearchResultsInterfaceFactory;
use Printq\StoreLocationsManagement\Api\SoftDrinkRepositoryInterface;
use Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink as ResourceSoftDrink;
use Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink\CollectionFactory as SoftDrinkCollectionFactory;

class SoftDrinkRepository implements SoftDrinkRepositoryInterface
{

    protected $resource;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $softDrinkCollectionFactory;

    protected $softDrinkFactory;

    private $storeManager;

    protected $dataObjectHelper;

    protected $dataSoftDrinkFactory;

    protected $dataObjectProcessor;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;


    /**
     * @param ResourceSoftDrink $resource
     * @param SoftDrinkFactory $softDrinkFactory
     * @param SoftDrinkInterfaceFactory $dataSoftDrinkFactory
     * @param SoftDrinkCollectionFactory $softDrinkCollectionFactory
     * @param SoftDrinkSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceSoftDrink $resource,
        SoftDrinkFactory $softDrinkFactory,
        SoftDrinkInterfaceFactory $dataSoftDrinkFactory,
        SoftDrinkCollectionFactory $softDrinkCollectionFactory,
        SoftDrinkSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->softDrinkFactory = $softDrinkFactory;
        $this->softDrinkCollectionFactory = $softDrinkCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataSoftDrinkFactory = $dataSoftDrinkFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface $softDrink
    ) {
        /* if (empty($softDrink->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $softDrink->setStoreId($storeId);
        } */
        
        $softDrinkData = $this->extensibleDataObjectConverter->toNestedArray(
            $softDrink,
            [],
            \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface::class
        );
        
        $softDrinkModel = $this->softDrinkFactory->create()->setData($softDrinkData);
        
        try {
            $this->resource->save($softDrinkModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the softDrink: %1',
                $exception->getMessage()
            ));
        }
        return $softDrinkModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($softDrinkId)
    {
        $softDrink = $this->softDrinkFactory->create();
        $this->resource->load($softDrink, $softDrinkId);
        if (!$softDrink->getId()) {
            throw new NoSuchEntityException(__('SoftDrink with id "%1" does not exist.', $softDrinkId));
        }
        return $softDrink->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->softDrinkCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface $softDrink
    ) {
        try {
            $softDrinkModel = $this->softDrinkFactory->create();
            $this->resource->load($softDrinkModel, $softDrink->getSoftdrinkId());
            $this->resource->delete($softDrinkModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the SoftDrink: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($softDrinkId)
    {
        return $this->delete($this->get($softDrinkId));
    }
}

