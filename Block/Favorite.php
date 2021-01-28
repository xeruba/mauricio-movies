<?php
namespace Mauricio\Movies\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Customer\Model\Session;

/**
 * Class Favorite
 * @package Mauricio\Movies\Block
 */
class Favorite extends Template
{
    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @var
     */
    protected $_product;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * Favorite constructor.
     * @param Context $context
     * @param Data $helper
     * @param StoreManagerInterface $storeManager
     * @param Session $customerSession
     */
    public function __construct(Context $context,
                                Data $helper,
                                StoreManagerInterface $storeManager,
                                Session $customerSession
    )
    {
        $this->_helper = $helper;
        $this->_storeManager = $storeManager;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        if(is_null($this->_product)){
            $this->_product = $this->_helper->getProduct();
        }
        return $this->_product;
    }

    /**
     * @return int
     * Return the id of the current product
     */
    public function getProductId(){
        return $this->getProduct()->getId();
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * Return the URL to the current page
     */
    public function getCurrentUrl() {
        return $this->_storeManager->getStore()->getCurrentUrl();
    }

    /**
     * @return int|null
     * Return the id of the logged in customer
     */
    public function getLoggedCustomerId(){
        return $this->_customerSession->getId();
    }

    /**
     * @return bool
     * Checks that a customer is logged in
     */
    public function hasLoggedCustomer(){
        return $this->_customerSession->isLoggedIn();
    }

}
