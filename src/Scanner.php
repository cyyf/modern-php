<?php

namespace cyyf\modern;

use GuzzleHttp\Client;
use League\Csv\Exception;

class Scanner
{
    protected $urls;

    protected $httpClient;

    public function __construct(array $urls)
    {
        $this->urls = $urls;
        $this->httpClient = new Client();
    }

    public function getInvalidUrls(){
        $invalidUrls = [];
        foreach ($this->urls as $url){
            try {
                $response = $this->httpClient->get($url);
                $statusCode = $response->getStatusCode();
            }catch (Exception $exception){
                $statusCode = 500;
            }

            if($statusCode >= 400){
                $invalidUrls[] = [
                    'url' => $url,
                    'status' => $response->getStatusCode()
                ];
            }
        }

        return $invalidUrls;
    }
}