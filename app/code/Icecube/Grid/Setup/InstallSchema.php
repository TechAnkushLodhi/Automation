<?php
namespace Icecube\Grid\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        if (!$installer->tableExists('grid_table')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('grid_table')
            )
            ->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'nullable' => false, 'primary' => true, 'unsigned' => true],
                'Entity ID'
            )
            ->addColumn(
                'name',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Name'
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                '64k',
                [],
                'Description'
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Created At'
            )
            ->addColumn(
                'updated_at',
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            )
            ->addColumn(
                'status',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 1],
                'Status'
            )
            ->addColumn(
                'type',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'Type'
            )
            ->addColumn(
                'sku',
                Table::TYPE_TEXT,
                255,
                ['nullable' => false],
                'SKU'
            )
            ->addColumn(
                'price',
                Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => false, 'default' => '0.0000'],
                'Price'
            )
            ->addColumn(
                'quantity',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 0],
                'Quantity'
            )
            ->addColumn(
                'weight',
                Table::TYPE_DECIMAL,
                '12,4',
                ['nullable' => false, 'default' => '0.0000'],
                'Weight'
            )
            ->addColumn(
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                ['nullable' => false, 'default' => 1],
                'Is Active'
            )
            ->addColumn(
                'visibility',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 4],
                'Visibility'
            )
            ->addColumn(
                'tax_class_id',
                Table::TYPE_INTEGER,
                null,
                ['nullable' => false, 'default' => 0],
                'Tax Class ID'
            )
            ->addColumn(
                'manufacturer',
                Table::TYPE_TEXT,
                255,
                ['nullable' => true],
                'Manufacturer'
            )
            ->setComment('Custom Table');
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}