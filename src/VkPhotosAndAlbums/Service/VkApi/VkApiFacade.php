<?php

namespace VkPhotosAndAlbums\Service\VkApi;

use VkPhotosAndAlbums\Service\VkApi\Contracts\VkPhotosAccess;

class VkApiFacade implements VkPhotosAccess
{
    /**
     * @var VkConnection
     */
    protected $connection;

    public function __construct(VkConnection $connection)
    {
        $this->connection = $connection;
    }

    public function getPhotos(array $userIds): array
    {
        $this->connection->callMethod('photos.getAll', $userIds);

        return $userIds;
    }
}