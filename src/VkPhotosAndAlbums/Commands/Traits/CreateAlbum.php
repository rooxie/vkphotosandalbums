<?php

namespace VkPhotosAndAlbums\Commands\Traits;

use VkPhotosAndAlbums\Models\Albums;

trait CreateAlbum
{
    public function createAlbum(array $album): void
    {
        $album = (new Albums())
            ->setId($album['id'])
            ->setOwnerId($album['owner_id'])
            ->setTitle($album['title'])
            ->setDescription($album['description'])
            ->setCreated($album['created'])
            ->setUpdated($album['updated'])
            ->setSize($album['size'])
            ->save();
    }
}