<?php
namespace Printq\NewColumnCartPage\Plugin;

class Convertquoteitemtoorder{
    public function aroundConvert(
     \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
     \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
     $additional = []
    ){
     $orderItem = $proceed($item, $additional);
        $orderItem->setProject_name($item->getProject_name());
     return $orderItem;
    }
}