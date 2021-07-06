<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Printq\Lastschrift\Model\Payment;

class Lastschrift extends \Magento\Payment\Model\Method\AbstractMethod
{

	/**
     * Payment code
     *
     * @var string
     */
    protected $_code = "lastschrift";
    
    protected $_isOffline = true;

    public function isAvailable(
        \Magento\Quote\Api\Data\CartInterface $quote = null
    ) {
        return parent::isAvailable($quote);
    }

}

