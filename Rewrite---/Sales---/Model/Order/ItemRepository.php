<?php
/**
 * @author        Theodor Flavian Hanu <theodorhanu@gmail.com>.
 * @copyright     Copyright(c) 2020 Theodor Hanu
 */

namespace Printq\Core\Rewrite\Sales\Model\Order;

use Magento\Sales\Api\Data\OrderItemInterface;

class ItemRepository extends \Magento\Sales\Model\Order\ItemRepository
    implements \Magento\Sales\Api\OrderItemRepositoryInterface
{

    /**
     * Perform persist operations for one entity
     *
     * @param OrderItemInterface $entity
     *
     * @return OrderItemInterface
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function save(OrderItemInterface $entity)
    {
        if ($entity->getProductOption()) {
            $request = $this->getBuyRequest($entity);
            $brData  = $entity->getBuyRequest()->getData();
            foreach ($brData as $key => $value) {
                if ( ! $request->hasData($key)) {
                    $request->setData($key, $value);
                }
            }
            $productOptions                    = $entity->getProductOptions();
            $productOptions['info_buyRequest'] = $request->toArray();
            $entity->setProductOptions($productOptions);
        }

        $this->metadata->getMapper()->save($entity);
        $this->registry[$entity->getEntityId()] = $entity;
        return $this->registry[$entity->getEntityId()];
    }
}
