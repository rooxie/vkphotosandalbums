<?php

namespace VkPhotosAndAlbums\Commands\Traits;

use VkPhotosAndAlbums\Models\Albums;

trait CreateAlbum
{
    public function createAlbum(array $album)
    {
        $album = (new Albums())
            ->setId($album['id'])
            ->setOwnerId($album['owner_id']);
    }
}