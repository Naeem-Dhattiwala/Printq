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
use Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterfaceFactory;
use Printq\StoreLocationsManagement\Api\Data\StoreLocationsSearchResultsInterfaceFactory;
use Printq\StoreLocationsManagement\Api\StoreLocationsRepositoryInterface;
use Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations as ResourceStoreLocations;
use Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations\CollectionFactory as StoreLocationsCollectionFactory;

class StoreLocationsRepository implements StoreLocationsRepositoryInterface
{

    protected $dataStoreLocationsFactory;

    protected $resource;

    protected $extensibleDataObjectConverter;
    protected $searchResultsFactory;

    protected $storeLocationsCollectionFactory;

    private $storeManager;

    protected $dataObjectHelper;

    protected $dataObjectProcessor;

    protected $extensionAttributesJoinProcessor;

    private $collectionProcessor;

    protected $storeLocationsFactory;


    /**
     * @param ResourceStoreLocations $resource
     * @param StoreLocationsFactory $storeLocationsFactory
     * @param StoreLocationsInterfaceFactory $dataStoreLocationsFactory
     * @param StoreLocationsCollectionFactory $storeLocationsCollectionFactory
     * @param StoreLocationsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceStoreLocations $resource,
        StoreLocationsFactory $storeLocationsFactory,
        StoreLocationsInterfaceFactory $dataStoreLocationsFactory,
        StoreLocationsCollectionFactory $storeLocationsCollectionFactory,
        StoreLocationsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->storeLocationsFactory = $storeLocationsFactory;
        $this->storeLocationsCollectionFactory = $storeLocationsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataStoreLocationsFactory = $dataStoreLocationsFactory;
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
        \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface $storeLocations
    ) {
        /* if (empty($storeLocations->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $storeLocations->setStoreId($storeId);
        } */
        
        $storeLocationsData = $this->extensibleDataObjectConverter->toNestedArray(
            $storeLocations,
            [],
            \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface::class
        );
        
        $storeLocationsModel = $this->storeLocationsFactory->create()->setData($storeLocationsData);
        
        try {
            $this->resource->save($storeLocationsModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the storeLocations: %1',
                $exception->getMessage()
            ));
        }
        return $storeLocationsModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function get($storeLocationsId)
    {
        $storeLocations = $this->storeLocationsFactory->create();
        $this->resource->load($storeLocations, $storeLocationsId);
        if (!$storeLocations->getId()) {
            throw new NoSuchEntityException(__('StoreLocations with id "%1" does not exist.', $storeLocationsId));
        }
        return $storeLocations->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->storeLocationsCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface::class
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
        \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface $storeLocations
    ) {
        try {
            $storeLocationsModel = $this->storeLocationsFactory->create();
            $this->resource->load($storeLocationsModel, $storeLocations->getStorelocationsId());
            $this->resource->delete($storeLocationsModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the StoreLocations: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($storeLocationsId)
    {
        return $this->delete($this->get($storeLocationsId));
    }
}

