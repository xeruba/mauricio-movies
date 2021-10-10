<?php

namespace Mauricio\Movies\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

use Mauricio\Movies\Service\MoviesServiceApi;

/**
 * Class Search
 * @package Mauricio\Movies\Controller\Adminhtml\Index
 */
class Search extends Action implements HttpGetActionInterface
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

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        MoviesServiceApi $api,
        \Magento\Framework\Registry $registry
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->api = $api;
        $this->_registry = $registry;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|Page
     */
    public function execute()
    {
        /**
         * Pegar informaçoes da busca
         * acessar model api e reaizar busca
         * salvar no o response no registry
         */
        $title_search = $this->getRequest()->getParam('title');
        $page = $this->getRequest()->getParam('page');
        $movies = $this->api->call($title_search, $page);
        $this->setResponseVariable('movies_response', $movies);
        $this->setResponseVariable('title_search', $title_search);

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
