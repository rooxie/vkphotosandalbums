<?php

namespace VkPhotosAndAlbums\Models;

use Propel\Runtime\Collection\Collection;
use VkPhotosAndAlbums\Models\Base\Photos as BasePhotos;

/**
 * Skeleton subclass for representing a row from the 'photos' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Photos extends BasePhotos
{
    public static function create(array $photo): void
    {
        $self = (new self())
            ->setId($photo['id'])
            ->setOwnerId($photo['owner_id'])
    }
}
