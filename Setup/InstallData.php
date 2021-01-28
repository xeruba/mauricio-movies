<?php

namespace Mauricio\Movies\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Setup\EavSetup;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
	private $eavSetupFactory;

    /**
     * @var AttributeSetFactory
     */
	private $attributeSetFactory;

    /**
     * @var CategorySetupFactory
     */
	private $categorySetupFactory;

    /**
     * InstallData constructor.
     * @param EavSetupFactory $eavSetupFactory
     * @param CategorySetupFactory $categorySetupFactory
     */
	public function __construct(
		EavSetupFactory $eavSetupFactory,
		AttributeSetFactory $attributeSetFactory,
		CategorySetupFactory $categorySetupFactory
	) {
		$this->eavSetupFactory = $eavSetupFactory;
		$this->attributeSetFactory = $attributeSetFactory;
		$this->categorySetupFactory = $categorySetupFactory;
	}

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
	{
		/*
		* New attribute set for the movies
		*/
		$categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

		$attributeSet = $this->attributeSetFactory->create();
		$entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
		$attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
		$data = [
			'attribute_set_name' => 'Movie',
			'entity_type_id' => $entityTypeId,
			'sort_order' => 5,
		];
		$attributeSet->setData($data);
		$attributeSet->validate();
		$attributeSet->save();
		$attributeSet->initFromSkeleton($attributeSetId);
		$attributeSet->save();

		/*
		* Attribute used to represents that a product is a movie, for the new attribute_set
		*/
		$eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

		$eavSetup->addAttribute(
			\Magento\Catalog\Model\Product::ENTITY,
			'is_movie',
			[
				'type' => 'int',
				'backend' => '',
				'frontend' => '',
				'label' => 'Is a movie',
				'input' => 'boolean',
				'class' => '',
				'source' => 'Magento\Catalog\Model\Product\Attribute\Source\Boolean',
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'user_defined' => false,
				'default' => '0',
				'searchable' => false,
				'filterable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'used_in_product_listing' => false,
				'unique' => false,
				'apply_to' => '',
				'attribute_set_id' => $attributeSet->getId(),
			]
		);
	}
}
