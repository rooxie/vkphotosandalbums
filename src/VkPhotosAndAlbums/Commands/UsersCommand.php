<?php

namespace VkPhotosAndAlbums\Commands;

use VkPhotosAndAlbums\Models\Users;
use VkPhotosAndAlbums\Models\UsersQuery;

class UsersCommand extends BaseCommand
{
    protected $args = ['user-id' => []];
    protected $usersInDb = [];

    protected function perform(): void
    {
        $localUsers = UsersQuery::create()->findById($this->args['user-id']);

        foreach ($localUsers as $user) {
            $this->usersInDb[] = $user->getId();
            $this->outputUser($user, 'Database');
        }

        if ($missing = array_diff($this->args['user-id'], $this->usersInDb)) {
            $remoteUsers = $this->vk()->getUsers($missing);

            foreach ($remoteUsers as $user) {
                $newUser = (new Users())
                    ->setId($user['uid'])
                    ->setFirstName($user['first_name'])
                    ->setLastName($user['last_name']);
                $newUser->save();
                $this->outputUser($newUser, 'Vk API');
            }
        }
    }

    protected function outputUser(Users $user, string $source): void
    {
        $this->output->writeln(PHP_EOL);
        $this->output->writeln('<info>Id: </info>' . $user->getId());
        $this->output->writeln('<info>First Name: </info>' . $user->getFirstName());
        $this->output->writeln('<info>Last Name: </info>' . $user->getLastName());
        $this->output->writeln('<info>Source: </info>' . $source);
    }
}