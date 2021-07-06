<?php
declare(strict_types=1);

namespace Printq\InvoiceStatus\Plugin\Model\Method;

class CheckmoPlugin
{

	public function afterCanCapture()
    {
        return true;
    }
}

