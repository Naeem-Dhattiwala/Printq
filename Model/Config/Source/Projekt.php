<?php
namespace Printq\NewFields\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class Projekt implements ArrayInterface
{
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }
    public function toOptionArray()
    {
        $result = [];
        $data = $this->scopeConfig->getValue("printqnewfield/printq/project",
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE,$this->storeManager->getStore()->getStoreId());
        $array = json_decode($data, true);
        foreach ($array as $value) {
            foreach ($value as $values) {
                 $result[] =[
                    'value' => $values,
                    'label' => $values,
                 ];
            }
        }
        return $result;
    }
}
?>