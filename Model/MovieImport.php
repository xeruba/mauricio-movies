<?php

namespace Mauricio\Movies\Model;

use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Mauricio\Movies\Service\ImportImageService;
use Magento\Store\Model\Store;


class MovieImport
{
    /**
     * @var ProductFactory
     */
    protected $_productFactory;
    /**
     * @var DateTime
     */
    protected $_dateTime;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;
    /**
     * @var ImportImageService
     */
    protected $_imageService;


    /**
     * MovieImport constructor.
     * @param ProductFactory $productFactory
     * @param DateTime $dateTime
     * @param StoreManagerInterface $storeManager
     * @param ImportImageService $imageService
     */
    public function __construct(
		ProductFactory $productFactory,
		DateTime $dateTime,
        StoreManagerInterface $storeManager,
        ImportImageService $imageService
    ) {
		$this->_productFactory = $productFactory;
		$this->_dateTime = $dateTime;
		$this->_storeManager = $storeManager;
		$this->_imageService = $imageService;
    }

    /**
     * @param $movie
     */
    public function import(Array $movie){

        /*
         * Checks that this movie was selected by the admin
         * */
        if (!$this->movieChecked($movie)){
            return false;
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // instance of object manager
        $productFactory = $objectManager->create('\Magento\Catalog\Model\Product');

        /*
         * Prapare the SKU unique key
         * */
        $sku = "movie[".$movie['id']."]";

		/* Searches for products based on the SKU as a KEY */
		$productLoaded = $productFactory->loadByAttribute('sku', $sku);

		/* if exists, overrides the product with the values */
		if($productLoaded) {
			$productFactory = $productLoaded;
		}

		/*
		 * Get the store_id of the default store, and the website_id from the default store view
		 * */
		$storeId = Store::DEFAULT_STORE_ID;
		$defaultWebsiteId = $this->_storeManager->getDefaultStoreView()->getWebsiteId();

		/*
		 * Compose the product with the suplied values from the user and the prepared values
		 * */
		$productFactory->setSku($sku)
            ->setName($movie['title'])

			->setPrice($movie['price'])
			->setDescription($movie['overview'])
			->setShortDescription($movie['overview'])
			->setAttributeSetId(4)
			->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
			->setWeight(1)
            ->setStoreId($storeId)
            ->setWebsiteIds([$defaultWebsiteId])
			->setVisibility(4) // visibilty of product (catalog / search / catalog, search / Not visible individually)
			->setTaxClassId(0) // Tax class id
			->setTypeId('simple')
            ->setStockData(
                array(
                    'use_config_manage_stock' => 0,
                    'manage_stock' => 1,
                    'is_in_stock' => 1,
                    'qty' => $movie['stock']
                )
            )
			->setCreatedAt($this->_dateTime->gmtDate())
            ->setIsMovie(true);

		/*
		 * Use the image service to store the image on the server
		 * */
		$this->_imageService->execute($productFactory, $movie['img'], $visible = false, ['image', 'small_image', 'thumbnail']);

        try {
            $productFactory->save();
            return true;
        }catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $movie
     * @return bool
     */
    private function movieChecked($movie){
        return array_key_exists('check', $movie);
    }
}
