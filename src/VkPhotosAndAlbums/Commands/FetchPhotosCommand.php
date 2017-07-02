<?php

namespace VkPhotosAndAlbums\Commands;

use Propel\Runtime\Exception\PropelException;
use Symfony\Component\Console\Helper\ProgressBar;
use VkPhotosAndAlbums\Commands\Traits\CreateUser;
use VkPhotosAndAlbums\Commands\Traits\FetchUsers;
use VkPhotosAndAlbums\Models\Photos;
use VkPhotosAndAlbums\Models\UsersQuery;

class FetchPhotosCommand extends BaseCommand
{
    use CreateUser, FetchUsers;

    protected $args = ['user-id' => []];

    protected function perform(): void
    {
        $userId = array_pop($this->args['user-id']);

        $user = UsersQuery::create()->findById($userId);

        if (!count($user)) {
            $user = $this->fetchUsers([$userId])[0];
            $this->createUser($user['id'], $user['first_name'], $user['last_name']);
        }

        $photos = $this->vk()->getPhotos($userId);

        $count = count($photos);
        $progress = new ProgressBar($this->output, $count);

        foreach ($photos as $photo) {
            try {
                Photos::create($photo);
            } catch (PropelException $e) {
            }

            $progress->advance();
        }
    }
}