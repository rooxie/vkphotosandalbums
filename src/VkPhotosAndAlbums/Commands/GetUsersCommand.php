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
        $count = count($users);

        $this->output->writeln("Found {$count} users in the database");

        foreach ($users as $user) {
            $this->output->writeln('');
            $this->output->writeln('<info>Id: </info>'          . $user->getId());
            $this->output->writeln('<info>First Name: </info>'  . $user->getFirstName());
            $this->output->writeln('<info>Last Name: </info>'   . $user->getLastName());
        }
    }
}