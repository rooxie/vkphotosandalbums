<?php

namespace VkPhotosAndAlbums\Service\VkApi;

use VkPhotosAndAlbums\Service\VkApi\Contracts\VkPhotosAccess;
use VkPhotosAndAlbums\Service\VkApi\Contracts\VkUsersAccess;

class VkApiFacade implements VkPhotosAccess, VkUsersAccess
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

    public function getUsers(array $userIds): array
    {
        return $this->connection->callMethod('users.get', ['user_ids' => $userIds]);
    }
}