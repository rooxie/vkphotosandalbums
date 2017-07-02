<?php

namespace VkPhotosAndAlbums\Commands;

use Carbon\Carbon;
use Symfony\Component\Console\Helper\ProgressBar;
use VkPhotosAndAlbums\Commands\Traits\CreateAlbum;
use VkPhotosAndAlbums\Commands\Traits\CreateUser;
use VkPhotosAndAlbums\Commands\Traits\FetchUsers;
use VkPhotosAndAlbums\Models\UsersQuery;

class AlbumsCommand extends BaseCommand
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
            $this->createAlbum($album);
            $progress->advance();
        }

        $progress->finish();
    }

    protected function outputAlbum(array $album): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln('<info>Id: </info>' . $album['id']);
        $this->output->writeln('<info>Owner Id: </info>' . $album['owner_id']);
        $this->output->writeln('<info>Title: </info>' . $album['title']);
        $this->output->writeln('<info>Size: </info>' . $album['size']);
        $this->output->writeln('<info>Created: </info>' . Carbon::createFromTimestamp($album['created'])->toFormattedDateString());
        $this->output->writeln('<info>Created: </info>' . Carbon::createFromTimestamp($album['updated'])->toFormattedDateString());
    }
}