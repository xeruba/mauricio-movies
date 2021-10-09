<?php

namespace Mauricio\Movies\Model;

use Exception;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Model\Store;
use Mauricio\Movies\Service\ImportImageService;

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
     * @param array $movie
     * @return bool
     * @throws Exception
     */
    public function import(array $movie)
    {
        /*
         * Checks that this movie was selected by the admin
         * */
        if (!$this->movieChecked($movie)) {
            return false;
        }
        $product = $this->_productFactory->create();

        /*
         * Prapare the SKU unique key
         */
        $sku = "mv-" . $movie['id'];

        /* Searches for products based on the SKU as a KEY */
        $productLoaded = $product->loadByAttribute('sku', $sku);

        /* if exists, overrides the product with the values */
        if ($productLoaded) {
            $product = $productLoaded;
        }

        /*
         * Get the store_id of the default store, and the website_id from the default store view
         */
        $storeId = Store::DEFAULT_STORE_ID;
        $defaultWebsiteId = $this->_storeManager->getDefaultStoreView()->getWebsiteId();

        /*
         * Compose the product with the supplied values from the user and the prepared values
         */
        $product->setSku($sku)
            ->setName($movie['title'])
            ->setPrice($movie['price'])
            ->setDescription($movie['overview'])
            ->setShortDescription($movie['overview'])
            ->setAttributeSetId(4)
            ->setStatus(Status::STATUS_ENABLED)
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
        $this->_imageService->execute($product, $movie['img'], false,
            ['image', 'small_image', 'thumbnail']);

        try {
            $product->save();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $movie
     * @return bool
     */
    private function movieChecked($movie)
    {
        return array_key_exists('check', $movie);
    }
}
