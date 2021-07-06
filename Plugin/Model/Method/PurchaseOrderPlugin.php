<?php
declare(strict_types=1);

namespace Printq\InvoiceStatus\Plugin\Model\Method;

class PurchaseOrderPlugin
{

	public function afterCanCapture()
    {
        return true;
    }
}

