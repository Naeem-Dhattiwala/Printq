<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Model;
    
    use Magento\Framework\Model\AbstractModel as MagentoAbstractModel;
    
    class Address extends MagentoAbstractModel {
        
        protected function _construct() {
            $this->_init( 'Printq\CustomAddress\Model\ResourceModel\Address' );
        }
    }
