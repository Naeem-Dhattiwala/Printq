<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          02/17/2021
     */
    
    namespace Printq\CustomAddress\Helper;
    
    use Magento\Framework\App\Helper\AbstractHelper;
    use Magento\Framework\App\Helper\Context;
    use Magento\Framework\App\ResourceConnection;
    use Magento\Store\Model\StoreManagerInterface;
    use Magento\Customer\Model\AddressFactory as MagentoAddressFactory;

    class Data extends AbstractHelper {
        
        protected $_scopeConfig;
        protected $storeManager;
        protected $resourceConnection;
    
        const XML_IS_ENABLED = "printq/customer_addresses/enable";
        const XML_CUSTOMER_ID = "printq/customer_addresses/customer_id";
        
        public function __construct(
            Context $context,
            StoreManagerInterface $storeManager,
            ResourceConnection  $resourceConnection,
            MagentoAddressFactory $addressFactory,
            $data = []
        ) {
            parent::__construct( $context );
            $this->storeManager = $storeManager;
            $this->resourceConnection = $resourceConnection;
            $this->magentoAddress = $addressFactory->create();
            return $this;
        }
        
        public function getConfig( $config_path ) {
            return $this->scopeConfig->getValue(
                $config_path,
                \Magento\Store\Model\ScopeInterface::SCOPE_STORE
            );
        }
        
        public function getCustomerId(){
            return $this->getConfig(self::XML_CUSTOMER_ID);
        }
        
        public function isEnabled(){
            return $this->getConfig(self::XML_IS_ENABLED);
        }
    
    
        public function getStoreId()
        {
            return $this->storeManager->getStore()->getId();
        }
        
        public function getAddresses(){
            $customerId = $this->getCustomerId();
            $store      = $this->getStoreId();
            $tableName  = $this->resourceConnection->getTableName( 'printq_default_address' );
            $collection = $this->magentoAddress->getCollection();
            $collection->getSelect()
                       ->join( [ 'printq_address' => $tableName ],
                               'e.entity_id = printq_address.address_id AND (e.parent_id = ' . $customerId . ' AND printq_address.store_id = ' . $store . ')' );
            
            return $collection;
        }
    }
