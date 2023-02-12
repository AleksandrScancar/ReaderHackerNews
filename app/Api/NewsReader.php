<?php


namespace App\Api;


use Exception;

class NewsReader
{
    //TODO rewrite to cURL class callers

    private const TOTAL_COUNT_READ = 100;
    private const ENDPOINT_NEWS = '/newstories';
    private const DETAIL = '/item/';
    private const FILE_TYPE = '.json';

    /** @var string */
    private $apiUri;

    /**
     * NewsReader constructor.
     */
    public function __construct(string $apiUri)
    {
        $this->apiUri = $apiUri;
    }

    /**
     * getIdsForItems returns newest ids from API
     *
     * @return array with results of ids for newest ids
     */
    public function getIdsForItems(): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUri.static::ENDPOINT_NEWS . static::FILE_TYPE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $this->checkErrorCurl($ch);
        curl_close($ch);
        return array_slice(json_decode($response,true), 0, static::TOTAL_COUNT_READ);
    }

    /**
     * getItemJson returns data from API
     *
     * @param string $id id of item
     * @return array return json object with data about item
     */
    public function getItemJson(string $id): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUri . static::DETAIL . $id . static::FILE_TYPE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $this->checkErrorCurl($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    /**
     * Checks cURL communication for error states
     *
     * @param $ch  - handle communication
     *
     * @throws CurlException if communication is not stable or HTTP method is wrong
     */
    private function checkErrorCurl($ch): void
    {
        if (!curl_errno($ch)) {
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode !== 200) {
                throw new Exception('Unexpected error while calling API, code:'.$httpCode);
            }
        }
    }
}