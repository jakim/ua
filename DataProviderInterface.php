<?php


namespace jakim\ua;


interface DataProviderInterface
{
    public function fetch(): array;
}