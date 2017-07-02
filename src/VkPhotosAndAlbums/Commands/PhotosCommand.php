<?php

namespace VkPhotosAndAlbums\Commands;

use Carbon\Carbon;
use VkPhotosAndAlbums\Commands\Traits\CreateUser;
use VkPhotosAndAlbums\Commands\Traits\FetchUsers;
use VkPhotosAndAlbums\Models\UsersQuery;

class PhotosCommand extends BaseCommand
{
    use CreateUser, FetchUsers;

    protected $args = ['user-id' => []];

    protected function perform(): void
    {
        $userId = array_pop($this->args['user-id']);

        $user = UsersQuery::create()->findById($userId);

        if (!count($user)) {
            $user = $this->fetchUsers([$userId])[0];
            $user = $this->createUser($user['id'], $user['first_name'], $user['last_name']);
        }

        $photos = $this->vk()->getPhotos($userId);

        foreach ($photos as $photo) {
            $this->outputPhoto($photo);
        }
    }

    protected function outputPhoto(array $photo): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln('<info>Id: </info>' . $photo['id']);
        $this->output->writeln('<info>Album Id: </info>' . ($photo['album_id'] > 0 ? $photo['album_id'] : ''));
        $this->output->writeln('<info>Owner Id: </info>' . $photo['owner_id']);

        foreach ([75, 130, 604, 807, 1280, 2560] as $size) {
            $sizeKey = 'photo_' . $size;
            if (isset($photo[$sizeKey])) {
                $this->output->writeln("<info>URL ({$size}): </info>" . $photo[$sizeKey]);
            }
        }

        foreach (['Width', 'Height'] as $prop) {
            $lcProp = strtolower($prop);

            if (isset($photo[$lcProp])) {
                $this->output->writeln("<info>{$prop}: </info>" . $photo[$lcProp]);
            }
        }

        $this->output->writeln('<info>Text: </info>' . $photo['text']);
        $this->output->writeln('<info>Uploaded: </info>' . Carbon::createFromTimestamp($photo['date'])->toFormattedDateString());
    }
}