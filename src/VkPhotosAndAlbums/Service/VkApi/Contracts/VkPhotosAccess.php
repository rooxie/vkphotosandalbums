<?php

namespace VkPhotosAndAlbums\Service\VkApi\Contracts;

interface VkPhotosAccess
{
    public function getPhotos(string $userId, int $limit = 200) : array;

    public function getAlbums(string $userId, int $limit = 200) : array;
}