<?php
namespace Printq\NewFields\Plugin\Quote;

class Convertquoteitemtoorder{
 public function aroundConvert(
     \Magento\Quote\Model\Quote\Item\ToOrderItem $subject,
     \Closure $proceed,
        \Magento\Quote\Model\Quote\Item\AbstractItem $item,
     $additional = []
 ) {
     $orderItem = $proceed($item, $additional);
        $orderItem->setVerrechnungskostenstelle($item->getVerrechnungskostenstelle());
        $orderItem->setVerrechnungskonto($item->getVerrechnungskonto());
        $orderItem->setBemerkung($item->getBemerkung());
        $orderItem->setWunschtermin($item->getWunschtermin());
     return $orderItem;
 }
}