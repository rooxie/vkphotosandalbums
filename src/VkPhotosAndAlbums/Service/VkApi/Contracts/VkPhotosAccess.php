<?php

namespace VkPhotosAndAlbums\Service\VkApi\Contracts;

interface VkPhotosAccess
{
    public function getPhotos(array $userIds) : array;
}