<?php


namespace jakim\ua;


class FileDataProvider implements DataProviderInterface
{
    public $path = __DIR__ . '/ua.data';

    public function __construct(?string $path = null)
    {
        if (null !== $path) {
            $this->path = $path;
        }
    }

    public function fetch(): array
    {
        return explode("\n", file_get_contents($this->path));
    }
}