<?php

namespace VkPhotosAndAlbums\Commands;

use Carbon\Carbon;

class PhotosCommand extends BaseCommand
{
    protected $args = ['user-id' => []];
    protected $usersInDb = [];

    protected function perform(): void
    {
        $photos = $this->vk()->getPhotos(array_pop($this->args['user-id']));

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