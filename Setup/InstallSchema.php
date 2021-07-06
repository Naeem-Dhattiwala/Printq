<?php
namespace Printq\Lastschrift\Setup;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();   
        $setup->getConnection()->addColumn(
            $setup->getTable('quote_payment'),
            'kontoinhaber',
            [
                'type' => 'text',
                'nullable' => true  ,
                'comment' => 'Kontoinhaber',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('quote_payment'),
            'iban',
            [
                'type' => 'text',
                'nullable' => true  ,
                'comment' => 'IBAN',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('quote_payment'),
            'bic',
            [
                'type' => 'text',
                'nullable' => true  ,
                'comment' => 'BIC',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_payment'),
            'kontoinhaber',
            [
                'type' => 'text',
                'nullable' => true  ,
                'comment' => 'Kontoinhaber',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_payment'),
            'iban',
            [
                'type' => 'text',
                'nullable' => true  ,
                'comment' => 'IBAN',
            ]
        );
        $setup->getConnection()->addColumn(
            $setup->getTable('sales_order_payment'),
            'bic',
            [
                'type' => 'text',
                'nullable' => true  ,
                'comment' => 'BIC',
            ]
        );
        $setup->endSetup();
  }
}