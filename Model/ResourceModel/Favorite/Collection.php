<?php

namespace Mauricio\Movies\Model\ResourceModel\Favorite;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'mauricio_movies_favorite_collection';
    protected $_eventObject = 'mauricio_movies_favorite_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Mauricio\Movies\Model\Favorite', 'Mauricio\Movies\Model\ResourceModel\Favorite');
    }

    /**
     * @return Collection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->columns(['catalog_product_entity.sku', 'favorite_times' => 'COUNT(*)'])
            ->joinLeft(
                $this->getTable('catalog_product_entity'),
                'catalog_product_entity.entity_id = main_table.product_id',
                ['product_sku' => 'catalog_product_entity.sku']
            )
            ->joinLeft(
                'eav_entity_type',
                "eav_entity_type.entity_type_code = 'catalog_product'",
                []
            )
            ->joinLeft(
                'eav_attribute',
                "eav_attribute.entity_type_id = eav_entity_type.entity_type_id AND eav_attribute.attribute_code = 'name'",
                []
            )
            ->joinLeft(
                'catalog_product_entity_varchar',
                "catalog_product_entity_varchar.entity_id = catalog_product_entity.entity_id AND catalog_product_entity_varchar.attribute_id = eav_attribute.attribute_id",
                ['movie_name' => 'value', 'attribute_id' => 'attribute_id']
            )
            ->group('main_table.product_id')
            ->order("favorite_times DESC")
            ->limit(10);
    }
}
