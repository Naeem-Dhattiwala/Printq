<?php
declare(strict_types=1);

namespace Printq\PaymentMethods\Model\Payment;

class PaymentMethods extends \Magento\Payment\Model\Method\AbstractMethod
{

    protected $_code = "paymentmethods";
    protected $_isOffline = true;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        return parent::isAvailable($quote);
    }
}

