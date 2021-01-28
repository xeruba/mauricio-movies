<?php
namespace Mauricio\Movies\Service;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Marketplace\Helper\Cache;
use Magento\Backend\Model\UrlInterface;
use Mauricio\Movies\Helper\Data;

class MoviesServiceApi
{
    /**
     * @var
     */
    public $test = 'false';

    /**
     * @var
     */
    protected $response = null;
    /**
     * @var Curl
     */
    protected $curlClient;

    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * @param Curl $curl
     * @param Cache $cache
     * @param UrlInterface $backendUrl
     * @param Data $helperData
     */
    public function __construct(Curl $curl, Cache $cache, UrlInterface $backendUrl, Data $helperData)
    {
        $this->curlClient = $curl;
        $this->_helperData = $helperData;

    }

    /**
     * @param $title
     * @return string
     */
    public function getApiUrl($title, $page): string
    {
        return str_replace (
            ' ',
            '%20',
            'https://api.themoviedb.org/3/search/movie?api_key='.$this->_helperData->getGeneralConfig('api_key').'&language=en-US&query='.$title.'&page='.$page.'&include_adult=false'
        );
    }

    /**
     * @param $title
     * @return array
     */
    public function call($title, $page)
    {

        try {
            $this->getCurlClient()->get($this->getApiUrl($title, $page));

            $response = json_decode($this->getCurlClient()->getBody(), true);

            if ($response) {
                $this->response = $response;
                return $this->response;
            }
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @return Curl
     */
    public function getCurlClient(): Curl
    {
        return $this->curlClient;
    }

    public function getResponse(){
        return $this->response;
    }
}
