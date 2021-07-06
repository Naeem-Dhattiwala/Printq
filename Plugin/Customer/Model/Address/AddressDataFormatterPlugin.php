<?php

namespace Printq\CustomAddress\Plugin\Customer\Model\Address;

class AddressDataFormatterPlugin
{

    public function afterPrepareAddress($subject, $result, $customerAddress)
    {
        $result['vat_id'] = $customerAddress->getVatId();
        return $result;
    }
}
