<?php
namespace Mauricio\Movies\Block\Adminhtml;

use Mauricio\Movies\Service\MoviesServiceApi;
use Mauricio\Movies\Helper\Data;

/**
 * Class Index
 * @package Mauricio\Movies\Block\Adminhtml
 */
class Results extends \Magento\Framework\View\Element\Template
{

    /**
     * @var MoviesServiceApi
     */
    protected $_registry;

    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * Results constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param Data $data
     */
	public function __construct(
	    \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        Data $helper_data
        )
	{
		parent::__construct($context);
        $this->_registry = $registry;
        $this->_helperData = $helper_data;
	}

	public function getMovies(){
	    if (array_key_exists('results',$this->getResponse())){
	        return $this->getResponse()['results'];
        }else{
	        return [];
        }
    }

    public function getMoviesCurrentPage(){
	    if (array_key_exists('page',$this->getResponse())){
	        return $this->getResponse()['page'];
        }else{
	        return 1;
        }
    }

    public function getMoviesTotalPages(){
	    if (array_key_exists('total_pages',$this->getResponse())){
	        return $this->getResponse()['total_pages'];
        }else{
	        return 1;
        }
    }

    private function getResponse(){
	    $response = $this->_registry->registry('movies_response');
	    if ($response){
	        return $response;
        }
	    return [];
    }

    public function getTitle(){
	    return $this->_registry->registry('title_search');
    }

    public function getDefaultPrice(){
	    return $this->_helperData->getGeneralConfig('price');
    }
    public function getDefaultStock(){
	    return $this->_helperData->getGeneralConfig('stock');
    }

    public function getImgSrc($poster_path){
	    if ($poster_path != null){
            return 'https://image.tmdb.org/t/p/w500/'.$poster_path;
        }
	    return ' ';
    }


}
