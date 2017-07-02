<?php

namespace VkPhotosAndAlbums\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VkPhotosAndAlbums\Service\VkApi\VkApiFacade;
use VkPhotosAndAlbums\Service\VkApi\VkConnection;

abstract class BaseCommand extends Command
{
    /**
     * @var OutputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var array
     */
    protected $args = [];

    /**
     * @var VkApiFacade
     */
    private $vkFacade = null;

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input    = $input;
        $this->output   = $output;

        foreach ($this->args as $arg => $values) {
            $this->args[$arg] = explode(',', $this->input->getArgument($arg));
        }

        $this->perform();
    }

    abstract protected function perform(): void;

    final protected function vk(): VkApiFacade
    {
        if ($this->vkFacade === null) {
            $this->vkFacade = new VkApiFacade(new VkConnection(getenv('VK_TOKEN')));
        }

        return $this->vkFacade;
    }
}