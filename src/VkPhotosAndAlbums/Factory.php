<?php

namespace VkPhotosAndAlbums;

use Symfony\Component\Console\Input\InputArgument;
use VkPhotosAndAlbums\Commands\PhotosCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class Factory
{
    public static function build(): Application
    {
        $appName = getenv('APP_NAME')   ?? 'Application';
        $version = getenv('VERSION')    ?? '1.0';

        $console = new Application($appName, $version);

        $command = new PhotosCommand('photos');
        $command->setDescription('Get user photos');
        $command->addArgument('User Id', InputArgument::REQUIRED, 'VK user ID');

        $console->addCommands([$command]);

        return $console;
    }

    private static function buildCommand(string $name, array $params)
    {
        $command = new Command($name);

        $command->setDescription($params['description'] ?? null);

        if ($params['args'] ?? null) {

        }
    }
}