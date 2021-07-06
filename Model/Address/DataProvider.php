<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Model\Address;
    
    use Magento\Customer\Api\CustomerRepositoryInterface;
    use Magento\Customer\Model\AttributeMetadataResolver;
    use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
    use Magento\Eav\Model\Entity\Type;
    use Magento\Eav\Model\Config;
    use Magento\Framework\View\Element\UiComponent\ContextInterface;
    use Magento\Ui\Component\Form\Element\Multiline;
    use Magento\Ui\DataProvider\AbstractDataProvider;
    use Magento\Customer\Model\AddressFactory as MagentoAddressFactory;
    use Printq\CustomAddress\Model\ResourceModel\Address\CollectionFactory as PrintqAddressFactory;
    
    class DataProvider extends AbstractDataProvider {
    
        /**
         * @var CustomerRepositoryInterface
         */
        private $customerRepository;
    
        /**
         * @var array
         */
        private $loadedData;
    
        /**
         * Allow to manage attributes, even they are hidden on storefront
         *
         * @var bool
         */
        private $allowToShowHiddenAttributes;
    
        /*
         * @var ContextInterface
         */
        private $context;
    
        /**
         * @var array
         */
        private $bannedInputTypes = ['media_image'];
    
        /**
         * @var array
         */
        private static $attributesToEliminate = [
            'region',
            'vat_is_valid',
            'vat_request_date',
            'vat_request_id',
            'vat_request_success',
            'country_id'
        ];
        
        protected $collection;
        
        private $magentoAddress;
    
        private $attributeMetadataResolver;
        
        public function __construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            PrintqAddressFactory $addressCollectionFactory,
            MagentoAddressFactory $magentoAddress,
            Config $eavConfig,
            ContextInterface $context,
            AttributeMetadataResolver $attributeMetadataResolver,
            $meta = [],
            $data = [],
            $allowToShowHiddenAttributes = true
        ) {
            parent::__construct( $name, $primaryFieldName, $requestFieldName, $meta, $data );
            $this->collection   = $addressCollectionFactory->create();
            $this->magentoAddress = $magentoAddress->create();
            $this->allowToShowHiddenAttributes = $allowToShowHiddenAttributes;
            $this->context = $context;
            $this->attributeMetadataResolver = $attributeMetadataResolver;
            $this->meta['address_details']['children'] = $this->getAttributesMeta(
                $eavConfig->getEntityType('customer_address')
            );
        }
        
        public function getData() {
            if (null !== $this->loadedData) {
                return $this->loadedData;
            }
            $items = $this->collection->getItems();
            
            foreach( $items as $item ) {
                $addressId = $item->getId();
                $magentoAddressId = $item->getAddressId();
                $magentoAddressCollection = $this->magentoAddress;
                $magentoAddressCollection = $magentoAddressCollection->getCollection();
                $magentoAddressCollection->addFieldToFilter('entity_id', $magentoAddressId);
                $magentoAddress = null;
                if( $magentoAddressCollection->getSize() ) {
                    $magentoAddress = $magentoAddressCollection->getData()[0];
                }
                $data = array_merge($magentoAddress,$item->getData());
                $this->loadedData[$addressId] = $data;
                $this->prepareAddressData($addressId, $this->loadedData);
            }
            return $this->loadedData;
        }
    
    
        /**
         * Prepare address data
         *
         * @param int $addressId
         * @param array $addresses
         * @return void
         */
        private function prepareAddressData($addressId, array &$addresses): void
        {
            foreach ($this->meta['address_details']['children'] as $attributeName => $attributeMeta) {
                if ($attributeMeta['arguments']['data']['config']['dataType'] === Multiline::NAME
                    && isset($this->loadedData[$addressId][$attributeName])
                    && !\is_array($this->loadedData[$addressId][$attributeName])
                ) {
                    $this->loadedData[$addressId][$attributeName] = explode(
                        "\n",
                        $this->loadedData[$addressId][$attributeName]
                    );
                }
            }
        }
    
        /**
         * Get attributes meta
         *
         * @param Type $entityType
         * @return array
         * @throws \Magento\Framework\Exception\LocalizedException
         */
        private function getAttributesMeta(Type $entityType): array
        {
            $meta = [];
            $attributes = $entityType->getAttributeCollection();
            /* @var AbstractAttribute $attribute */
            foreach ($attributes as $attribute) {
                if (\in_array($attribute->getFrontendInput(), $this->bannedInputTypes, true)) {
                    continue;
                }
                if (\in_array($attribute->getAttributeCode(), self::$attributesToEliminate, true)) {
                    continue;
                }
                $meta[$attribute->getAttributeCode()] = $this->attributeMetadataResolver->getAttributesMeta(
                    $attribute,
                    $entityType,
                    $this->allowToShowHiddenAttributes,
                    $this->getRequestFieldName()
                );
            }
            $this->attributeMetadataResolver->processWebsiteMeta($meta);
            return $meta;
        }
    }
