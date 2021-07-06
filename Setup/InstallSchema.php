<?php

namespace Printq\NewFields\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

	public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
	{
		$installer = $setup;
		$installer->startSetup();
			$table = $installer->getConnection()->newTable(
				$installer->getTable('printq_new_field')
			)
				->addColumn(
					'id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[
						'identity' => true,
						'nullable' => false,
						'primary'  => true,
						'unsigned' => true,
					],
					'ID'
				)
				->addColumn(
					'order_id',
					\Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
					null,
					[],
					'Order Id'
				)
				->addColumn(
					'projekt',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Projekt '
				)
				->addColumn(
					'verteilerschlussel',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Verteilerschlussel'
				)
				->addColumn(
					'verrechnungskostenstelle',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Verrechnungskostenstelle'
				)
				->addColumn(
					'verrechnungskonto',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Verrechnungskonto'
				)
				->addColumn(
					'bemerkung',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Bemerkung'
				)
				->addColumn(
					'wunschtermin',
					\Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
					255,
					[],
					'Wunschtermin'
				)
				->setComment('Printq Custom Field');
			$installer->getConnection()->createTable($table);
			$installer->getConnection()->addIndex(
				$installer->getTable('printq_new_field'),
				$setup->getIdxName(
					$installer->getTable('printq_new_field'),
					['projekt', 'verteilerschlussel', 'verrechnungskostenstelle', 'verrechnungskonto','bemerkung','wunschtermin'],
					\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
				),
				['projekt', 'verteilerschlussel', 'verrechnungskostenstelle', 'verrechnungskonto','bemerkung','wunschtermin'],
				\Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
			);
		$installer->endSetup();
	}
}