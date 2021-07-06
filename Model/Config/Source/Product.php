<?php
namespace Printq\StoreLocationsManagement\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

class Product implements ArrayInterface
{
    protected $productCollectionFactory;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->productCollectionFactory = $productCollectionFactory;
    }
    public function toOptionArray()
    {
        $result = [];
        $products = $this->productCollectionFactory->create()->addAttributeToSelect('*');
        foreach ($products as $values) {
                 $result[] =[
                    'value' => $values->getId(),
                    'label' => $values->getName()
                 ];
            }
        return $result;
    }
}
?>