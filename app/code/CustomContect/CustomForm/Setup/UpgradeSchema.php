<?php
// File: app/code/CustomContect/CustomForm/Setup/UpgradeSchema.php
namespace CustomContect\CustomForm\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            // Add 'status' column
            $setup->getConnection()->addColumn(
                $setup->getTable('registration_form'),
                'status',
                [
                    'type' => Table::TYPE_INTEGER,
                    'nullable' => false,
                    'default' => 0,
                    'comment' => 'Status'
                ]
            );
        }

        $setup->endSetup();
    }
}
