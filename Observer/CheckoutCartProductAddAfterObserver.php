<?php

namespace Printq\NewFields\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class CheckoutCartProductAddAfterObserver implements ObserverInterface
{
    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $_layout;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    protected $_request;
    /**
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\View\LayoutInterface $layout
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\LayoutInterface $layout,
        \Magento\Framework\App\RequestInterface $request
    )
    {
        $this->_layout = $layout;
        $this->_storeManager = $storeManager;
        $this->_request = $request;
    }
    /**
     * Add order information into GA block to render on checkout success pages
     *
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        /* @var \Magento\Quote\Model\Quote\Item $item */
        $item = $observer->getQuoteItem();
        $item->setVerrechnungskostenstelle($this->_request->getParam('verrechnungskostenstelle'));
        $item->setVerrechnungskonto($this->_request->getParam('verrechnungskonto'));
        $item->setBemerkung($this->_request->getParam('bemerkung'));
        $item->setWunschtermin($this->_request->getParam('wunschtermin'));
    }
}