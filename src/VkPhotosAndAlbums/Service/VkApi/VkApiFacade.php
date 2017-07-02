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
        $collection = [];

        $getBatch = function (int $offset) use ($userId, $limit): array {
            return $this->connection->callMethod('photos.getAll', [
                'owner_id'  => $userId,
                'count'     => $limit,
                'offset'    => $offset
            ]);
        };

        $add = function (int $fetched = 0) use (&$collection, $getBatch, &$add): void {
            $batch = $getBatch($fetched);

            if ($photos = $batch['data']) {
                foreach ($photos['items'] as $photo) {
                    if (!isset($collection[$photo['id']])) {
                        $collection[$photo['id']] = $photo;
                        $fetched++;
                    }
                }

                if ($photos['count'] - $fetched > 0) {
                    $add($fetched);
                }
            }
        };

        $add();

        return $collection;
    }

    public function getAlbums(string $userId, int $limit = 200): array
    {
        $collection = [];

        $getBatch = function (int $offset) use ($userId, $limit): array {
            return $this->connection->callMethod('photos.getAll', [
                'owner_id'  => $userId,
                'count'     => $limit,
                'offset'    => $offset
            ]);
        };

        $add = function (int $fetched = 0) use (&$collection, $getBatch, &$add): void {
            $batch = $getBatch($fetched);

            if ($photos = $batch['data']) {
                foreach ($photos['items'] as $photo) {
                    if (!isset($collection[$photo['id']])) {
                        $collection[$photo['id']] = $photo;
                        $fetched++;
                    }
                }

                if ($photos['count'] - $fetched > 0) {
                    $add($fetched);
                }
            }
        };

        $add();

        return $collection;
    }
}