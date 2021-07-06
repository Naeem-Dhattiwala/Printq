<?php

namespace Printq\NewColumnCartPage\Plugin\Checkout\Model;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Quote\Api\CartItemRepositoryInterface as QuoteItemRepository;

class Defaultconfigprovider extends \Magento\Framework\Model\AbstractModel
{
	private $checkoutSession;
	private $quoteItemRepository;
    protected $scopeConfig;
	public function __construct(
        CheckoutSession $checkoutSession,
        QuoteItemRepository $quoteItemRepository,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->quoteItemRepository = $quoteItemRepository;
    }
    public function afterGetConfig(
    	\Magento\Checkout\Model\DefaultConfigProvider $subject,
    	array $result
    ){
    	$items = $result['totalsData']['items'];
    	foreach ($items as $index => $item) {
    		$quoteItem = $this->checkoutSession->getQuote()->getItemById($item['item_id']);
    		$result['quoteItemData'][$index]['project'] = $quoteItem->getProject_name();
    	}
    	return $result;
    }
}