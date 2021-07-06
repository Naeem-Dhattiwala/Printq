<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Controller\Adminhtml\Manage;
    
    use Magento\Backend\App\Action as BackendAction;
    use Magento\Backend\App\Action\Context;
    use Magento\Customer\Model\AddressFactory as MagentoAddressFactory;
    use Printq\CustomAddress\Logger\Manage as Logger;
    use Printq\CustomAddress\Model\AddressFactory;
    use Printq\CustomAddress\Helper\Data as Helper;
    
    class Save extends BackendAction {
        
        protected $addressFactory;
        
        protected $logger;
        
        protected $magentoAddress;
        
        protected $helper;
        
        protected $customerId = 1;
        
        protected $keysToIgnore = [
            'key','back', 'entity_id', 'parent_id', 'created_at', 'updated_at', 'is_active', 'id', 'address_id', 'name', 'customer_group', 'store_id', 'country', 'form_key'
        ];
        
        public function __construct(
            Context $context,
            MagentoAddressFactory $magentoAddress,
            AddressFactory $addressFactory,
            Logger $logger,
            Helper $helper
        ) {
            parent::__construct( $context );
            $this->magentoAddress = $magentoAddress->create();
            $this->addressFactory = $addressFactory;
            $this->logger               = $logger;
            $this->helper = $helper;
            $this->customerId = $this->helper->getCustomerId();
        }
    
        public function execute() {
            $redirectBack = $this->getRequest()->getParam( 'back', false );
            $id           = $this->getRequest()->getParam( 'id', 0 );
            $data         = $this->getRequest()->getParams();
    
            try {
                $model = $this->addressFactory->create();
            
                if ( $id !== 0 ) {
                    $model->load( $id );
                    if ( $id != $model->getId() ) {
                        throw new \Exception( __( 'Wrong Address specified.' ) );
                    }
                }
                $magentoAddressId = $data['address_id'];
                $magentoAddress = null;
                $save = false;
                if( $magentoAddressId ) {
                    $magentoAddressCollection = $this->magentoAddress->getCollection();
                    $magentoAddressCollection->addFieldToFilter('entity_id', $magentoAddressId);
                    if( $magentoAddressCollection->getSize() ) {
                        $magentoAddress = $magentoAddressCollection->fetchItem();
                    }
                } else {
                    $magentoAddress = $this->magentoAddress;
                    $magentoAddress->setParentId($this->customerId);
                    $save = true;
                }
                foreach($data as $key => $value ) {
                    if( in_array($key, $this->keysToIgnore ) ) {
                        continue;
                    }
                    if( $key === "region_id" && $value === "" && $magentoAddress->getData($key) === "0" ) {
                        continue;
                    }
                    if( $key === "street" ) {
                        $street = trim(implode( "\n", $value ));
                        if( $street === $magentoAddress->getData( $key ) ) {
                            continue;
                        }
                    }
                    if( $value != $magentoAddress->getData($key) ) {
                        $magentoAddress->setData( $key, $value );
                        $save = true;
                    }
                }
                if( $save ) {
                    $magentoAddress->save();
                }
                $data['address_id'] = $magentoAddress->getEntityId();
                $model->setName( $data['name'] )
                      ->setAddressId( (int)$data['address_id'] )
                      ->setCustomerGroup( (int)$data['customer_group'] )
                      ->setStoreId( (int)$data['store_id'] );
    
                if ( $id ) {
                    $this->logger->info( 'Address #' . $id . ' has been changed to:' );
                    $this->logger->info( print_r( $model->getData(), TRUE ) );
                }
                $model->save();
                $id = $model->getId();
                $this->getMessageManager()->addSuccessMessage( __( 'Address saved!' ) );
            } catch ( \Exception $e ) {
                $this->logger->critical($e->getMessage());
                $this->getMessageManager()->addErrorMessage( $e->getMessage() );
            }
            if ( $redirectBack ) {
                $this->_redirect( '*/*/edit', [
                    'id'       => $id,
                    '_current' => true
                ] );
            } else {
                $this->_redirect( '*/*/index' );
            }
        }
        
        /**
         * Check permission via ACL resource
         */
        protected function _isAllowed() {
            return $this->_authorization->isAllowed( 'Magento_Customer::manage' );
        }
    }
