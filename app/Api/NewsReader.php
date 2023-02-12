<?php

declare(strict_types = 1);

namespace App\Api;

use Exception;
use function curl_init;
use function curl_setopt;
use const CURLOPT_URL;
use const CURLOPT_CUSTOMREQUEST;
use const CURLOPT_RETURNTRANSFER;
use function curl_exec;
use function curl_close;
use function array_slice;
use function json_decode;
use function curl_errno;
use function curl_getinfo;
use const CURLINFO_HTTP_CODE;

final class NewsReader
{

    //TODO rewrite to cURL class callers

    private const TOTAL_COUNT_READ = 100;
    private const ENDPOINT_NEWS = '/newstories';
    private const DETAIL = '/item/';
    private const FILE_TYPE = '.json';

    /**
     * NewsReader constructor.
     */
    public function __construct(private string $apiUri)
    {
    }

    /**
     * getIdsForItems returns newest ids from API
     *
     * @return array with results of ids for newest ids
     */
    public function getIdsForItems(): array
    {
        $ch = curl_init();
        curl_setopt($ch, \CURLOPT_URL, $this->apiUri . self::ENDPOINT_NEWS . self::FILE_TYPE);
        curl_setopt($ch, \CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $this->checkErrorCurl($ch);
        \curl_close($ch);

        return array_slice(json_decode($response, true), 0, self::TOTAL_COUNT_READ);
    }

    /**
     * getItemJson returns data from API
     *
     * @param  int $id id of item
     * @return array return json object with data about item
     */
    public function getItemJson(int $id): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUri . self::DETAIL . $id . self::FILE_TYPE);
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
     * @param  $ch - handle communication
     * @throws \Exception if communication is not stable or HTTP method is wrong
     */
    private function checkErrorCurl($ch): void
    {
        if (!\curl_errno($ch)) {
            $httpCode = \curl_getinfo($ch, \CURLINFO_HTTP_CODE);

            if (200 !== $httpCode) {
                throw new \Exception('Unexpected error while calling API, code:' . $httpCode);
            }
        }
    }

}
