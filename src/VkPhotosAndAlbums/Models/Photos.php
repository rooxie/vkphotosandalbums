<?php

namespace VkPhotosAndAlbums\Models;

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
            ->setText($photo['text'])
            ->setCreated($photo['date']);

        if (isset($photo['Width'])) {
            $self->setWidth($photo['width']);
        }

        if (isset($photo['Height'])) {
            $self->setWidth($photo['height']);
        }

        foreach ([75, 130, 604, 807, 1280, 2560] as $size) {
            $sizeKey = 'photo_' . $size;
            $method = 'setPhoto' . $size;
            if (isset($photo[$sizeKey])) {
                $self->$method($photo[$sizeKey]);
            }
        }

        $self->save();
    }
}
