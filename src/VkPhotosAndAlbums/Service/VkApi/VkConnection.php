<?php

namespace VkPhotosAndAlbums\Service\VkApi;

use GuzzleHttp\Exception\BadResponseException;

class VkConnection
{
    const API_VERSION = '5';
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
        $this->token = $token;
        $this->guzzle = new \GuzzleHttp\Client();
    }

    public function callMethod(string $methodName, array $params = []): array
    {
        $params['access_token'] = $this->token;
        $return = [];

        try {
            $response = $this->guzzle->get(self::REQUEST_URL . $methodName, ['query' => $params]);
            $content = json_decode($response->getBody()->getContents(), true);
            $return = $content['response'];
        } catch (BadResponseException | \Exception $e) {
            var_dump($e->getMessage());
        }

        return $return;
    }
}