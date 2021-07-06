<?php
namespace Printq\StoreLocationsManagement\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class State implements ArrayInterface
{
    protected $regionFactory;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Directory\Model\RegionFactory $regionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->regionFactory = $regionFactory;
    }
    public function toOptionArray()
    {
        $result = [];
        $states = $this->regionFactory->create()->getCollection()->addFieldToFilter('country_id','US');
        $result[] =[
                    'value' => '',
                    'label' => 'Please Select'
                 ];
        foreach ($states as $values) {
                 $result[] =[
                    'value' => $values->getName(),
                    'label' => $values->getName()
                 ];
            }
        return $result;
    }
}
?>