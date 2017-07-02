<?php

namespace VkPhotosAndAlbums\Commands;

use Propel\Runtime\Exception\PropelException;
use Symfony\Component\Console\Helper\ProgressBar;
use VkPhotosAndAlbums\Commands\Traits\CreateAlbum;
use VkPhotosAndAlbums\Commands\Traits\CreateUser;
use VkPhotosAndAlbums\Commands\Traits\FetchUsers;
use VkPhotosAndAlbums\Models\Albums;
use VkPhotosAndAlbums\Models\UsersQuery;

class FetchAlbumsCommand extends BaseCommand
{
    use CreateUser, FetchUsers, CreateAlbum;

    protected $args = ['user-id' => []];
    protected $usersInDb = [];

    protected function perform(): void
    {
        $userId = array_pop($this->args['user-id']);

        $user = UsersQuery::create()->findById($userId);

        if (!count($user)) {
            $user = $this->fetchUsers([$userId])[0];
            $this->createUser($user['id'], $user['first_name'], $user['last_name']);
        }

        $albums = $this->vk()->getAlbums($userId);

        $count = count($albums);
        $progress = new ProgressBar($this->output, $count);

        foreach ($albums as $album) {
            try {
                Albums::create($album);
            } catch (PropelException $e) {}

            $progress->advance();
        }

        $progress->finish();
    }
}