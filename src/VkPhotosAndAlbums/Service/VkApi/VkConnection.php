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

    public function callMethod(string $methodName, array $params = [])
    {
        try {
            $response = $this->guzzle->get(self::REQUEST_URL . $methodName, [
                'query' => [
                    'user_ids' => ['7306153'],
                    'access_token' => $this->token
                ]
            ]);
            $content = json_decode($response->getBody()->getContents(), true);
            var_dump($content); die;
        } catch (BadResponseException | \Exception $e) {
            var_dump($e->getMessage()); die;
        }


        var_dump($response);
    }
}