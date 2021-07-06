<?php
    /**
     *
     * @author        Delescu Andrei Vlad <ad@cloudlab.at>.
     * @copyright     Copyright(c) 2020 CloudLab AG (https://cloudlab.ag)
     * @link          https://cloudlab.ag/
     * @date          03/23/2021
     */
    
    namespace Printq\CustomAddress\Setup;
    
    use Magento\Framework\DB\Ddl\Table;
    use Magento\Framework\Setup\SchemaSetupInterface;
    use Magento\Framework\Setup\UpgradeSchemaInterface;
    use Magento\Framework\Setup\ModuleContextInterface;
    
    class UpgradeSchema implements UpgradeSchemaInterface {
        
        public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
            $setup->startSetup();
            
            if( version_compare( $context->getVersion(), '1.0.2', '<' ) ) {
                $this->addCustomAddress( $setup );
            }
            $setup->endSetup();
        }
        
        
        /**
         * @param \Magento\Framework\Setup\SchemaSetupInterface $setup
         *
         * @throws \Zend_Db_Exception
         */
        private function addCustomAddress( SchemaSetupInterface $setup ) {
            $printqDefaultAddress = $setup->getTable( 'printq_default_address' );
            if( $setup->getConnection()->isTableExists( $printqDefaultAddress ) != true ) {
                    $setup->run( "
                        CREATE TABLE `printq_default_address` (
                          `id` int(10) UNSIGNED NOT NULL auto_increment,
                          `address_id` INT(10) UNSIGNED NOT NULL UNIQUE,
                          `name` varchar(255) NULL,
                          `customer_group` int (10) UNSIGNED NOT NULL,
                          `store_id` smallint (5) UNSIGNED NOT NULL,
                          PRIMARY KEY  (`id`),
                          CONSTRAINT `FK_address_id_printq_default_address` FOREIGN KEY (`address_id`) REFERENCES `customer_address_entity`(`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                          CONSTRAINT `FK_customer_group_printq_default_address` FOREIGN KEY (`customer_group`) REFERENCES `customer_group`(`customer_group_id`) ON DELETE CASCADE ON UPDATE CASCADE,
                          CONSTRAINT `FK_store_id_printq_default_address` FOREIGN KEY (`store_id`) REFERENCES `store`(`store_id`) ON DELETE CASCADE ON UPDATE CASCADE
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                " );
            }
        }
    }
