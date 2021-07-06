<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/22/2021
     */
    
    namespace Printq\CustomAddress\Model\ResourceModel\Address;
    
    use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
    
    class Collection extends AbstractCollection{
        
        protected function _construct() {
            $this->_init( 'Printq\CustomAddress\Model\Address', 'Printq\CustomAddress\Model\ResourceModel\Address' );
        }
    }
