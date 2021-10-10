<?php

namespace Mauricio\Movies\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Message\ManagerInterface;
use Mauricio\Movies\Model\MovieImport;
use Mauricio\Movies\Service\MoviesServiceApi;

/**
 * Class Index
 * @package Mauricio\Movies\Controller\Adminhtml
 */
class Index extends Action
{
    const ACTION_RESOURCE = 'Mauricio_Movies::movies_index';

    /**
     * @var MoviesServiceApi
     */
    protected $api;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var MovieImport
     */
    protected $_movieImport;

    /**
     * @var ManagerInterface
     */
    protected $_messageManager;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param MoviesServiceApi $api
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        MoviesServiceApi $api,
        Registry $registry,
        MovieImport $movieImport,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context);
        $this->api = $api;
        $this->_registry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        $this->_movieImport = $movieImport;
        $this->_messageManager = $messageManager;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     * This function is used to search for movies, and import movies as products
     */
    public function execute()
    {
        /*
         * The param array 'search' represents variables used to consume the movies api
         */
        if ($search = $this->getRequest()->getParam('search')) {
            $title_search = $search['title'];
            $page = $search['page'];
            $movies = $this->api->call($title_search, $page);
            $this->setResponseVariable('movies_response', $movies);
            $this->setResponseVariable('title_search', $title_search);
        }
        /*
         * The param array 'products' represents the movies that must be imported
         */
        if ($products = $this->getRequest()->getParam('products')) {
            $qtn_import = 0;
            foreach ($products as $product) {
                if ($this->_movieImport->import($product)) {
                    $qtn_import++;
                }
            }
            if ($qtn_import > 0) {
                $this->_messageManager->addSuccessMessage("Movies saved!");
            } else {
                $this->_messageManager->addErrorMessage("Movies not imported.");
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(static::ACTION_RESOURCE);
        $resultPage->getConfig()->getTitle()->prepend(__('Index'));

        return $resultPage;
    }

    /**
     * Save custom variable in registry
     * @param $name
     * @param $value
     */
    public function setResponseVariable($name, $value)
    {
        $this->_registry->register($name, $value);
    }
}
