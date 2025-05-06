<?php
namespace CustomContect\CustomForm\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;


class InstallSchema implements InstallSchemaInterface
{
    
  public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
  {
      
    $RegistrationTable = $setup->getTable('registration_form');

    if($setup->getConnection()->isTableExists($RegistrationTable) != true) {

      $newTable = $setup->getConnection()
          ->newTable($RegistrationTable)
          ->addColumn(
              'id',
              Table::TYPE_INTEGER,
              null,
              ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
              'News ID'
          )
          ->addColumn(
              'name',
              Table::TYPE_TEXT,
              255,
              ['nullable' => false, 'default' => ''],
                'Title'
          )
          ->addColumn(
            'date_of_birth',
            Table::TYPE_DATE,
            null,
            ['nullable' => false],
            'Date of Birth'
        )
        ->addColumn(
            'birth_place',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Birth Place'
        )
        ->addColumn(
            'marital_status',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Marital Status'
        )
        ->addColumn(
            'education',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Education'
        )
        ->addColumn(
            'job_title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Job Title'
        )
        ->addColumn(
            'graduated_school',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Graduated School'
        )
        ->addColumn(
            'contact_number',
            Table::TYPE_TEXT,
            20,
            ['nullable' => false],
            'Contact Number'
        )
        ->addColumn(
            'address',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Address'
        )
        ->addColumn(
            'email',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Email'
        )
        ->addColumn(
            'gender',
            Table::TYPE_TEXT,
            10,
            ['nullable' => false],
            'Gender'
        )
        ->addColumn(
            'image',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Image'
        )
        ->addColumn(
            'interests',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Interests'
        )
        ->addColumn(
            'hobby',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Hobby'
        )
        ->addColumn(
            'emergency_information',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Emergency Information'
        )
        ->addColumn(
            'relations',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Relations'
        )
        ->addColumn(
            'emergency_contact',
            Table::TYPE_TEXT,
            20,
            ['nullable' => true],
            'Emergency Contact'
        )
        ->addColumn(
            'status',
            Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Status'
        )
          ->setComment("Registration form");

      $setup->getConnection()->createTable($newTable);
    }
  }
}
?>
