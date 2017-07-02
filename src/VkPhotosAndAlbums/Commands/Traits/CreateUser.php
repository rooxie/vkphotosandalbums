<?php

namespace VkPhotosAndAlbums\Commands\Traits;

use VkPhotosAndAlbums\Models\Users;

trait CreateUser
{
    protected function createUser(string $id, string $firstName, string $lastName): Users
    {
        $user = (new Users())
            ->setId($id)
            ->setFirstName($firstName)
            ->setLastName($lastName);

        $user->save();

        return $user;
    }
}