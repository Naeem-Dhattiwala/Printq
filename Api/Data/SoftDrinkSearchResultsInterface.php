<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Api\Data;

interface SoftDrinkSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get SoftDrink list.
     * @return \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface[]
     */
    public function getItems();

    /**
     * Set name list.
     * @param \Printq\StoreLocationsManagement\Api\Data\SoftDrinkInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

