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
    use Magento\Framework\Controller\ResultFactory;
    use Magento\Framework\Registry;
    use Printq\CustomAddress\Model\AddressFactory;
    
    class Edit extends BackendAction {
        
        protected $addressFactory;
        
        protected $coreRegistry;
        
        public function __construct(
            Context $context,
            AddressFactory $addressFactory,
            Registry $coreRegistry
        ) {
            parent::__construct( $context );
            $this->addressFactory = $addressFactory;
            $this->coreRegistry = $coreRegistry;
            
        }
        
        public function execute() {
            
            $id        = $this->getRequest()->getParam( 'id', 0 );
            $data_item = $this->addressFactory->create();
            if( $id ) {
                try {
                    $data_item = $data_item->load( $id );
                } catch( \Magento\Framework\Exception\NoSuchEntityException $exception ) {
                    $this->messageManager->addError( __( 'This address no longer exists.' ) );
                    return $this->_redirect( $this->getUrl( '*/*/index' ) );
                }
            }
            
            $data = $this->_getSession()->getPageData( true );
            
            if( !empty( $data ) && $id == 0 ) {
                $data_item->addData( $data );
            }
            
            if ( $data_item->getId() || $id == 0 ) {
                $this->coreRegistry->register( 'data_item', $data_item );
                
                /**
                 * @var \Magento\Framework\View\Result\Page $resultPage
                 */
                $resultPage = $this->resultFactory->create( ResultFactory::TYPE_PAGE );
                
                //Set the menu which will be active for this page
                $resultPage->setActiveMenu( 'Printq_CustomAddress::address_manage' );
                
                //Set the header title of grid
                $resultPage->getConfig()->getTitle()->prepend( __( 'Edit Address \'%1\'', [ $data_item->getName() ] ) );
                
                return $resultPage;
            } else {
                $this->messageManager->addErrorMessage( __( 'Address does not exist.' ) );
                
                return $this->_redirect( $this->getUrl( '*/*/index' ) );
            }
        }
        
        /**
         * Check permission via ACL resource
         */
        protected function _isAllowed() {
            return $this->_authorization->isAllowed( 'Magento_Customer::manage' );
        }
    }
