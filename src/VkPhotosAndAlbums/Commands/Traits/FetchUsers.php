<?php

namespace VkPhotosAndAlbums\Commands\Traits;

trait FetchUsers
{
    protected function fetchUsers(array $userIds): array
    {
        $users = $this->vk()->getUsers($userIds);

        if (!$users) {
            $this->output->writeln("Couldn't fetch users from Vk API");
            exit();
        }

        return $users;
    }
}
