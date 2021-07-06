<?php
declare(strict_types=1);

namespace Printq\NewPurchaseOrderStatus\Plugin\Model\Method;

class AbstractMethod extends \Magento\Payment\Model\Method\AbstractMethod
{

	public function aftercanCapture()
    {
        return true;
    }
}

