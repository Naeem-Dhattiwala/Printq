<?php
/**
 * Created by PhpStorm.
 * User: th
 * Date: 27 Iul 2017
 * Time: 16:54
 */

namespace Printq\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Data extends AbstractHelper
{

    const CONFIG_XML_PATH_DISABLE_UNIT_PRICE_ROUNDING = 'printq/core_calculation/disable_unit_price_rounding';

    protected $_scopeConfig;

    protected $_priceCurrency;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        PriceCurrencyInterface $priceCurrency,
        $data = []
    ) {
        parent::__construct($context);
        $this->_scopeConfig   = $scopeConfig;
        $this->_priceCurrency = $priceCurrency;

        return $this;
    }

    public function roundPrice($price)
    {
        return $this->_priceCurrency->round($price);
    }

    public function disableUnitPriceRounding()
    {
        return (bool)$this->_scopeConfig->getValue(self::CONFIG_XML_PATH_DISABLE_UNIT_PRICE_ROUNDING, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }
}
