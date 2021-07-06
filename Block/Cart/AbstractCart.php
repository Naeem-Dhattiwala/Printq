<?php
 
namespace Printq\NewColumnCartPage\Block\Cart;
 
class AbstractCart
{
 
	public function afterGetItemRenderer(\Magento\Checkout\Block\Cart\AbstractCart $subject, $result)
	{
        $result->setTemplate('Printq_NewColumnCartPage::cart/item/default.phtml');
    	return $result;
	}
}