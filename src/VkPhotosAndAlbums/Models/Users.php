<?php

namespace VkPhotosAndAlbums\Models;

use VkPhotosAndAlbums\Models\Base\Users as BaseUsers;

/**
 * Skeleton subclass for representing a row from the 'users' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Users extends BaseUsers
{
    public static function create(array $user): void
    {
        (new self())
            ->setId($user['id'])
            ->setFirstName($user['first_name'])
            ->setLastName($user['last_name'])
            ->save();
    }
}
