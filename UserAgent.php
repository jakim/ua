<?php
/**
 * Created for IG Monitoring.
 * User: jakim <pawel@jakimowski.info>
 * Date: 11.01.2018
 */

namespace jakim\ua;


class UserAgent implements UserAgentInterface
{
    /**
     * @var array|\jakim\ua\DataProviderInterface[]
     */
    public $dataProviders = [
        WhatIsMyBrowserDataProvider::class,
        FileDataProvider::class,
        ArrayDataProvider::class,
    ];

    public function __construct(?array $dataProviders = null)
    {
        if (null !== $dataProviders) {
            $this->dataProviders = $dataProviders;
        }
    }

    public function fetch(): array
    {
        foreach ($this->dataProviders as $dataProvider) {
            if (is_string($dataProvider)) {
                $dataProvider = new $dataProvider();
            }
            $items = $dataProvider->fetch();
            if (!empty($items)) {
                return $items;
            }
        }

        return [];
    }

    public function random(): ?string
    {
        $items = $this->fetch();
        shuffle($items);

        return $items['0'] ?? null;
    }
}