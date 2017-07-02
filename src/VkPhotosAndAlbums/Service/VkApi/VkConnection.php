<?php

namespace VkPhotosAndAlbums\Service\VkApi;

use GuzzleHttp\Exception\BadResponseException;

class VkConnection
{
    const API_VERSION = '5.64';
    const REQUEST_URL = 'https://api.vk.com/method/';

    /**
     * @var \GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * @var string
     */
    protected $token;

    public function __construct(string $token)
    {
        $this->token    = $token;
        $this->guzzle   = new \GuzzleHttp\Client();
    }

    public function callMethod(string $methodName, array $params = []): array
    {
        $params['access_token'] = $this->token;
        $params['v']            = self::API_VERSION;

        $return                 = ['data'  => [], 'error' => ''];

        try {
            $response   = $this->guzzle->get(self::REQUEST_URL . $methodName, ['query' => $params]);
            $content    = json_decode($response->getBody()->getContents(), true);

            if (!array_key_exists('response', $content)) {
                $error = $content['error'] ?? null;
                throw new \Exception(!$error ? 'Got no data from Vk API' : $error['error_msg']);
            }

            $return['data'] = $content['response'];
        } catch (BadResponseException | \Exception $e) {
            $return['error'] = $e->getMessage();
        }

        return $return;
    }
}