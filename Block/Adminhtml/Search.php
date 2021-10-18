<?php

namespace Mauricio\Movies\Block\Adminhtml;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mauricio\Movies\Service\MoviesServiceApi;

/**
 * Class Index
 * @package Mauricio\Movies\Block\Adminhtml
 */
class Search extends Template
{

    /**
     * @var MoviesServiceApi
     */
    protected $_registry;

    /**
     * Search constructor.
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->_registry = $registry;
    }

    /**
     * @return array|mixed
     * Return the results present on the response get from the movies api
     */
    public function getMovies()
    {
        if (array_key_exists('results', $this->getResponse())) {
            return $this->getResponse()['results'];
        } else {
            return [];
        }
    }

    /**
     * @return int|mixed
     * Returns the current page of the movies api response
     */
    public function getMoviesCurrentPage()
    {
        if (array_key_exists('page', $this->getResponse())) {
            return $this->getResponse()['page'];
        } else {
            return 1;
        }
    }

    /**
     * @return int|mixed
     * Return the number of pages of the current movies api response
     */
    public function getMoviesTotalPages()
    {
        if (array_key_exists('total_pages', $this->getResponse())) {
            return $this->getResponse()['total_pages'];
        } else {
            return 1;
        }
    }

    /**
     * @return array|mixed
     * Return the complete response of the movies api
     */
    private function getResponse()
    {
        $response = $this->_registry->registry('movies_response');
        if ($response) {
            return $response;
        }
        return [];
    }

    /**
     * @return mixed|null
     * Return the title used for search on the movies api
     */
    public function getTitle()
    {
        return $this->_registry->registry('title_search');
    }

}
