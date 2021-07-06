<?php

namespace Printq\NewOrderField\Plugin\Admin\Order;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Sales\Model\ResourceModel\Order\Grid\Collection;
use Magento\User\Model\ResourceModel\User\Collection as UserCollection;

class Grid extends \Magento\Framework\Data\Collection
{
    protected $coreResource;

    protected $adminUsers;

    public function __construct(
        EntityFactoryInterface $entityFactory,
        ResourceConnection $coreResource,
        UserCollection $adminUsers
    ) {
        parent::__construct($entityFactory);
        $this->coreResource = $coreResource;
        $this->adminUsers = $adminUsers;
    }

    public function beforeLoad($printQuery = false, $logQuery = false)
    {
        if ($printQuery instanceof Collection) {
            $collection = $printQuery;

            $joined_tables = array_keys(
                $collection->getSelect()->getPart('from')
            );

            $collection->getSelect()
                ->columns(
                    array(
                        'telephone' => new \Zend_Db_Expr('(SELECT GROUP_CONCAT(`telephone` SEPARATOR " & ") FROM `sales_order_address` WHERE main_table.`entity_id` = `sales_order_address`.`parent_id` AND `sales_order_address`.`address_type` = "shipping")')
                    )
                );
            $collection->getSelect()
                ->columns(
                    array(
                        'dilevery_info' => new \Zend_Db_Expr('(SELECT GROUP_CONCAT(`deposit_instruction` SEPARATOR " & ") FROM `sales_order` WHERE `main_table`.`entity_id` = sales_order.`entity_id`)')
                    )
                );

        }
    }
}
