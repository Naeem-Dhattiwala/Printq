<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Model\ResourceModel;
    
    use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
    
    class Address extends AbstractDb{
        
        protected function _construct() {
            $this->_init( 'printq_default_address', 'id' );
        }
    }
