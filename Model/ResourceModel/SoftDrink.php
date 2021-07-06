<?php
declare(strict_types=1);

namespace Printq\StoreLocationsManagement\Model\ResourceModel;

class SoftDrink extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('printq_storelocationsmanagement_softdrink', 'softdrink_id');
    }
}

