<?php


namespace jakim\ua;


interface UserAgentInterface extends DataProviderInterface
{
    public function random(): ?string;
}