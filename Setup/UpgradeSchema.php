<?php
namespace Printq\NewFields\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
	public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {
		$installer = $setup;
		$installer->startSetup();
			if (version_compare($context->getVersion(), '1.0.1', '<')) {
				$installer->getConnection()->addColumn(
					$installer->getTable( 'sales_order_item' ),
					'verrechnungskostenstelle',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Verrechnungskostenstelle'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'sales_order_item' ),
					'verrechnungskonto',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Verrechnungskonto'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'sales_order_item' ),
					'bemerkung',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Bemerkung'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'sales_order_item' ),
					'wunschtermin',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Wunschtermin'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'quote_item' ),
					'verrechnungskostenstelle',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Verrechnungskostenstelle'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'quote_item' ),
					'verrechnungskonto',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Verrechnungskonto'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'quote_item' ),
					'bemerkung',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Bemerkung'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'quote_item' ),
					'wunschtermin',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Wunschtermin'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'printq_new_field' ),
					'product_id',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Product id'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'printq_new_field_2' ),
					'product_id',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Product id'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'printq_new_field' ),
					'product_name',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Product Name'
					]
				);
				$installer->getConnection()->addColumn(
					$installer->getTable( 'printq_new_field_2' ),
					'product_name',
					[
						'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
		                'length' => 255,
		                'nullable' => false,
		                'comment' => 'Product Name'
					]
				);
		}
		$installer->endSetup();
	}
}
