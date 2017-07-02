<?php

namespace VkPhotosAndAlbums\Service\VkApi\Contracts;

interface VkUsersAccess
{
    public function getUsers(array $userIds) : array;
}