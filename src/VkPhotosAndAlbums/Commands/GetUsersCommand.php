<?php

namespace VkPhotosAndAlbums\Commands;

use VkPhotosAndAlbums\Commands\Traits\CreateUser;
use VkPhotosAndAlbums\Models\Users;
use VkPhotosAndAlbums\Models\UsersQuery;

class GetUsersCommand extends BaseCommand
{
    use CreateUser;

    protected $args = ['user-id' => []];
    protected $usersInDb = [];

    protected function perform(): void
    {
        $users = UsersQuery::create()->findById($this->args['user-id']);

        foreach ($users as $user) {
            $this->outputUser($user);
        }
    }

    protected function outputUser(Users $user): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln('<info>Id: </info>' . $user->getId());
        $this->output->writeln('<info>First Name: </info>' . $user->getFirstName());
        $this->output->writeln('<info>Last Name: </info>' . $user->getLastName());
    }
}