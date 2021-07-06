<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface SoftDrinkRepositoryInterface
{

    /**
     * Save SoftDrink
     * @param \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface $softDrink
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface $softDrink
    );

    /**
     * Retrieve SoftDrink
     * @param string $softdrinkId
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($softdrinkId);

    /**
     * Retrieve SoftDrink matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete SoftDrink
     * @param \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface $softDrink
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface $softDrink
    );

    /**
     * Delete SoftDrink by ID
     * @param string $softdrinkId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($softdrinkId);
}

