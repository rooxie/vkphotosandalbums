<?php

namespace VkPhotosAndAlbums;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class Factory
{
    private const COMMANDS_NAMESPACE = '\\VkPhotosAndAlbums\\Commands\\';

    public static function build(array $propel): Application
    {
        self::propel($propel);

        $appName = getenv('APP_NAME')   ?? 'Application';
        $version = getenv('VERSION')    ?? '1.0';

        $console = new Application($appName, $version);

        $commands = json_decode(file_get_contents(__DIR__ . '/../../config/commands.json'), true);

        foreach ($commands as $name => $details) {
            $console->add(self::buildCommand($name, $details));
        }

        return $console;
    }

    private static function buildCommand(string $name, array $details): Command
    {
        if (!isset($details['class'])) {
            throw new \Exception('Command class must be provided');
        }

        /** @var Command $command */

        $class = self::COMMANDS_NAMESPACE . $details['class'];
        $command = new $class($name);

        $command->setDescription($details['description'] ?? null);

        foreach ($details['args'] ?? [] as $argName => $argDetails) {
            $required = ($argDetails['required'] ?? false) ? InputArgument::REQUIRED : InputArgument::OPTIONAL;
            $command->addArgument($argName, $required, $argDetails['description'] ?? null);
        }

        foreach ($details['opts'] ?? [] as $optName => $optDetails) {
            $command->addOption($optName, $optDetails['shortcut'] ?? null, null, $optDetails['description'] ?? null);
        }

        return $command;
    }

    private static function propel(array $propel): void
    {
        $name   = getenv('DB_NAME');
        $config = $propel['propel']['database']['connections'][$name];

        $conatiner = \Propel\Runtime\Propel::getServiceContainer();
        $conatiner->setAdapterClass($name, 'mysql');
        $manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
        $manager->setConfiguration([
            'classname'  => $config['classname'],
            'dsn'        => $config['dsn'],
            'user'       => $config['user'],
            'password'   => $config['password'],
            'attributes' => $config['attributes'],
        ]);
        $manager->setName($name);
        $conatiner->setConnectionManager($name, $manager);
        $conatiner->setDefaultDatasource($name);
    }
}