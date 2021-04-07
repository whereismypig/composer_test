<?php

namespace Houqihui\Url;

use GuzzleHttp\Client;

class Scanner
{
	protected $urls;
	protected $httpClient;

	public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new Client();
    }

    /**
     * 获取访问指定URL的HTTP状态码
     * @return Client
     */
    public function getStatusCodeForUrl($url)
    {
        $httpResponse = $this->httpClient->get($url);
        return $httpResponse->getStatusCode();
    }

    /**
     * @return Client
     */
    public function getInvalidUrls()
    {
        $invalidUrls = [];
        foreach ($this->urls as $url) {
            try {
                $statusCode = $this->getStatusCodeForUrl($url);
            } catch(\Exception $e) {
                $statusCode = 500;
            }

            if ($statusCode >= 400) {
                $invalidUrls[] = ['url'=>$url, 'code'=>$statusCode];
            }

        }

        return $invalidUrls;
    }

}
