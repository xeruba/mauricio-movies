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
    public function __construct(
        Curl $curl,
        Cache $cache,
        UrlInterface $backendUrl,
        Data $helperData
    ) {
        $this->curlClient = $curl;
        $this->_helperData = $helperData;
    }

    /**
     * @param $title
     * @param $page
     * @return string
     */
    public function getApiUrl($title, $page): string
    {
        $params = [
            'api_key' =>  $this->_helperData->getGeneralConfig('api_key'),
            'language' => 'en-US',
            'query' => str_replace(' ', '%20', $title),
            'page' => $page,
            'include_adult' => false
        ];

        return 'https://api.themoviedb.org/3/search/movie?' . http_build_query($params);
    }

    /**
     * @param $title
     * @param $page
     * @return array|mixed|void
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

    public function getResponse()
    {
        return $this->response;
    }
}
