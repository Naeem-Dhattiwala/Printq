<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface StoreLocationsRepositoryInterface
{

    /**
     * Save StoreLocations
     * @param \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface $storeLocations
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface $storeLocations
    );

    /**
     * Retrieve StoreLocations
     * @param string $storelocationsId
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($storelocationsId);

    /**
     * Retrieve StoreLocations matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete StoreLocations
     * @param \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface $storeLocations
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface $storeLocations
    );

    /**
     * Delete StoreLocations by ID
     * @param string $storelocationsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($storelocationsId);
}

