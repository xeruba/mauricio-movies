<?php
namespace Mauricio\Movies\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

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
     * @var \Magento\Framework\Registry
     */
	protected $_registry;

	protected $_movieImport;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param MoviesServiceApi $api
     * @param \Magento\Framework\Registry $registry
     */
	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
        MoviesServiceApi $api,
        \Magento\Framework\Registry $registry,
        MovieImport $movieImport
	) {
		parent::__construct($context);
        $this->api = $api;
        $this->_registry = $registry;
		$this->resultPageFactory = $resultPageFactory;
		$this->_movieImport = $movieImport;
	}

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|Page
     * This function is used to search for movies, and import movies as products
     */
	public function execute()
	{
	    /*
         * The param array 'search' represents variables used to consume the movies api
         */
	    if($search = $this->getRequest()->getParam('search')){
            $title_search = $search['title'];
            $page = $search['page'];
            $movies = $this->api->call($title_search, $page);
            $this->setResponseVariable('movies_response', $movies);
            $this->setResponseVariable('title_search', $title_search);
        }
        /*
         * The param array 'products' represents the movies that must be imported
         */
	    if($products = $this->getRequest()->getParam('products')){
            foreach ($products as $product){
                $this->_movieImport->import($product);
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
