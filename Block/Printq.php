<?php

namespace Printq\CustomerOrderSection\Block;

class Printq extends \Magento\Framework\View\Element\Template
{
    protected $storeManagerInterface;

    protected $productRepository;

    protected $orderRepository;

    protected $addressConfig;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Customer\Model\Address\Config $addressConfig,
        array $data = []
    ) {
        $this->storeManagerInterface = $storeManagerInterface;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->addressConfig = $addressConfig;
        parent::__construct($context, $data);
    }
    public function getMediaUrl()
    {
        $currentStore = $this->storeManagerInterface->getStore();
        $mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl;
    }
    public function getBaseUrl()
    {
        $currentStore = $this->storeManagerInterface->getStore();
        $baseUrl = $currentStore->getBaseUrl();
        return $baseUrl;
    }
    public function getProduct($id)
    {
        return $this->productRepository->getById($id);
    }
    public function getCurrencySymbol() {
        return $this ->_storeManager-> getStore()->getBaseCurrency()->getCurrencySymbol();
    }
    public function getOrderPrintUrl() {
        $currentStore = $this->storeManagerInterface->getStore();
        $printOrderUrl = $currentStore->getBaseUrl() . 'sales/order/print/order_id/';
        return $printOrderUrl;
    }
    public function getOrderInvoiceUrl() {
        $currentStore = $this->storeManagerInterface->getStore();
        $printOrderUrl = $currentStore->getBaseUrl() . 'sales/order/printInvoice/order_id/';
        return $printOrderUrl;
    }
     public function getShippingAddressHtml($orderId){
        try {
            $order = $this->orderRepository->get($orderId);
        } catch (NoSuchEntityException $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__('This order no longer exists.'));
        }
        $address = $order->getShippingAddress();
        $renderer = $this->addressConfig->getFormatByCode('html')->getRenderer();
        return $renderer->renderArray($address);
    }
    public function getBillingAddressHtml($orderId){
        try {
            $order = $this->orderRepository->get($orderId);
        } catch (NoSuchEntityException $e) {
            throw new \Magento\Framework\Exception\LocalizedException(__('This order no longer exists.'));
        }
        $address = $order->getBillingAddress();
        $renderer = $this->addressConfig->getFormatByCode('html')->getRenderer();
        return $renderer->renderArray($address);
    }
}