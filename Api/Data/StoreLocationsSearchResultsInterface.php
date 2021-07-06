<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Api\Data;

interface StoreLocationsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get StoreLocations list.
     * @return \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface[]
     */
    public function getItems();

    /**
     * Set address list.
     * @param \Printq\StoreLocationsManagement\Api\Data\StoreLocationsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

