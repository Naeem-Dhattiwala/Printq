<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'storelocations_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Printq\StoreLocationsManagement\Model\StoreLocations::class,
            \Printq\StoreLocationsManagement\Model\ResourceModel\StoreLocations::class
        );
    }
}

