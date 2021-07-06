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
    use Printq\CustomAddress\Model\AddressFactory;
    
    class Delete extends BackendAction {
        
        protected $addressFactory;
        
        /**
         * @param \Magento\Backend\App\Action\Context $context
         * @param AddressFactory $addressFactory
         */
        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            AddressFactory $addressFactory
        ) {
            parent::__construct( $context );
            $this->addressFactory = $addressFactory;
        }
        
        public function execute() {
            
            $resultRedirect = $this->resultRedirectFactory->create();
            $id             = $this->getRequest()->getParam( 'id' );
            if( $id ) {
                try {
                    $address = $this->addressFactory->create();
                    $address->load( $id );
                    $address->delete();
                    
                    $this->messageManager->addSuccessMessage( __( 'Address Deleted!' ) );
                    return $resultRedirect->setPath( '*/*/' );
                } catch( \Exception $e ) {
                    $this->messageManager->addErrorMessage( $e->getMessage() );
                    return $resultRedirect->setPath( '*/*/index');
                }
            }
            // display error message
            $this->messageManager->addErrorMessage( __( 'We can\'t find the address to delete.' ) );
            // go to grid
            return $this->_redirect( $this->getUrl( '*/*/index' ) );
        }
        
        /**
         * Check permission via ACL resource
         */
        protected function _isAllowed() {
            return $this->_authorization->isAllowed( 'Magento_Customer::manage' );
        }
    }
