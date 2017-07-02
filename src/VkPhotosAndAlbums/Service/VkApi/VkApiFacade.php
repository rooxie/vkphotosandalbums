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

    public function getUsers(array $userIds): array
    {
        return $this->connection->callMethod('users.get', ['user_ids' => $userIds])['data'];
    }

    public function getPhotos(string $userId, int $limit = 200): array
    {
        return $this->getCollection('photos.getAll', $userId, $limit);
    }

    public function getAlbums(string $userId, int $limit = 200): array
    {
        return $this->getCollection('photos.getAlbums', $userId, $limit);
    }

    protected function getCollection(string $method, string $userId, int $limit = 200): array
    {
        $collection = [];

        $fetch = function (int $offset) use ($method, $userId, $limit): array {
            return $this->connection->callMethod($method, [
                'owner_id'  => $userId,
                'count'     => $limit,
                'offset'    => $offset
            ]);
        };

        $add = function (int $count = 0) use (&$collection, $fetch, &$add): void {
            $batch = $fetch($count);

            if ($data = $batch['data']) {
                foreach ($data['items'] as $item) {
                    if (!isset($collection[$item['id']])) {
                        $collection[$item['id']] = $item;
                        $count++;
                    }
                }

                if ($data['count'] - $count > 0) {
                    $add($count);
                }
            }
        };

        $add();

        return $collection;
    }
}