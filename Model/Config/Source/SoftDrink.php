<?php
namespace Printq\StoreLocationsManagement\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class SoftDrink implements ArrayInterface
{
    protected $softdrinkfactory;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Printq\StoreLocationsManagement\Model\SoftDrinkFactory $softdrinkfactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->softdrinkfactory = $softdrinkfactory;
    }
    public function toOptionArray()
    {
        $result = [];
        $Softdrink = $this->softdrinkfactory->create();
        $collection = $Softdrink->getCollection();
        foreach ($collection as $values) {
                 $result[] =[
                    'value' => $values->getSoftdrink_id(),
                    'label' => $values->getName()
                 ];
            }
        return $result;
    }
}
?>