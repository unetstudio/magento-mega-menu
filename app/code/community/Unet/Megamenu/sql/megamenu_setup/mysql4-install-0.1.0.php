<?php
/**
 * Created by PhpStorm.
 * User: duc
 * Date: 17/08/2015
 * Time: 15:24
 */
$installer = $this;
$tableName = $installer->getTable('megamenu/megamenu');
$installer->startSetup();
if ($installer->getConnection()->isTableExists($tableName) != true) {
    $table = $installer->getConnection()->newTable($tableName)
        ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
        ), 'Item ID')
        ->addColumn('item_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => false,
        ), 'Item Name')
        ->addColumn('item_link', Varien_Db_Ddl_Table::TYPE_TEXT, 512, array(
            'nullable' => true,
            'default' => '',
        ), 'Item Link')
        ->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
            'nullable' => false,
            'default' => 1,
        ), 'Sort Order')
        ->addColumn('menu_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 31, array(
            'nullable' => false,
        ), 'Menu Type')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 1, array(
            'nullable' => false,
        ), 'Status')
        ->addColumn('content_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 127, array(
            'nullable' => false,
        ), 'Content Type')
        ->addColumn('column', Varien_Db_Ddl_Table::TYPE_INTEGER, 2, array(
            'nullable' => false,
            'default' => 1,
        ), 'Columns')
        ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'default' => null,
        ), 'Item Content')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'default' => null,
        ), 'Created At')
        ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
            'default' => null,
        ), 'Updated At');


    $installer->getConnection()->createTable($table);
}
$installer->endSetup();
