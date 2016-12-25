<?php
/**
 * SMS
 * 
 * @author Slava Yurthev
 */
$installer = $this;
$installer->startSetup();
$table_templates = $installer->getTable('sy_sms/sy_sms_templates');
$table_variables = $installer->getTable('sy_sms/sy_sms_variables');
$table_orders = $installer->getTable('sy_sms/sy_sms_orders');
$table_stream = $installer->getTable('sy_sms/sy_sms_stream');

// $installer->getConnection()->dropTable($table_templates);
// $installer->getConnection()->dropTable($table_variables);
// $installer->getConnection()->dropTable($table_orders);
// $installer->getConnection()->dropTable($table_stream);

$table = $installer->getConnection()
    ->newTable($table_templates)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('label', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('model', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('msg', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
        ));
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($table_variables)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('identifier', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('label', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('model', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('path', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ));
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($table_orders)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        ))
    ->addColumn('sms_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => true,
        ));
$installer->getConnection()->createTable($table);

$table = $installer->getConnection()
    ->newTable($table_stream)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ))
    ->addColumn('external_id', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('reciver', Varien_Db_Ddl_Table::TYPE_TEXT, '255', array(
        'nullable'  => true,
        ))
    ->addColumn('msg', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable'  => true,
        ))
    ->addColumn('sent', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => true,
        ))
    ->addColumn('recived', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => true,
        ));
$installer->getConnection()->createTable($table);

$installer->endSetup();