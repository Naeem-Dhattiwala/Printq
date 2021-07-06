<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Controller\Adminhtml\Manage;
    
    use Magento\Backend\App\Action;
    use Magento\Framework\Controller\ResultFactory;
    
    class Add extends Action {
        
        
        public function execute() {
            $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
            $resultPage->setActiveMenu( 'Printq_CustomAddress::address_manage' );
            $resultPage->getConfig()->getTitle()->prepend( __( 'New Address' ) );
            
            return $resultPage;
            
        }
        
        /**
         * Check permission via ACL resource
         */
        protected function _isAllowed() {
            return $this->_authorization->isAllowed( 'Magento_Customer::manage' );
        }
    }
