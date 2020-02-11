<?php


namespace jakim\ua;


class ArrayDataProvider implements DataProviderInterface
{
    public $data = [];

    public function __construct(?array $data = [])
    {
        if (null != $data) {
            $this->data = $data;
        }
    }

    public function fetch(): array
    {
        return $this->data;
    }
}