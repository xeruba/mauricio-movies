<?php

namespace Mauricio\Movies\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        /*
         * Create a table to persist the customers favorite movies
         * */
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mauricio_movies_favorites')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mauricio_movies_favorites')
            )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    'customer_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Customer ID'
                )
                ->addColumn(
                    'product_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Product ID'
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'catalog_product_entity',
                        'entity_id',
                        'mauricio_movies_favorites',
                        'product_id'
                    ),
                    'product_id',
                    $installer->getTable('catalog_product_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $installer->getFkName(
                        'customer_entity',
                        'entity_id',
                        'mauricio_movies_favorites',
                        'customer_id'
                    ),
                    'customer_id',
                    $installer->getTable('customer_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addIndex(
                    $installer->getIdxName('mauricio_movies_favorites', ['product_id', 'customer_id']),
                    [
                        'product_id',
                        'customer_id'
                    ]
                )
                ->setComment('Users favorite movies');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
