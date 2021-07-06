<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'softdrink_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Printq\StoreLocationsManagement\Model\SoftDrink::class,
            \Printq\StoreLocationsManagement\Model\ResourceModel\SoftDrink::class
        );
    }
}

