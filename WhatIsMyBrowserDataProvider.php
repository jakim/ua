<?php


namespace jakim\ua;


use DOMDocument;
use DOMXPath;
use Throwable;

class WhatIsMyBrowserDataProvider implements DataProviderInterface
{
    public $urls = [
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/1',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/2',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/3',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/4',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/5',
    ];

    public function __construct(?array $urls = null)
    {
        if (null !== $urls) {
            $this->urls = $urls;
        }
    }


    public function fetch(): array
    {
        $items = [];
        try {
            $dom = new DOMDocument();
            foreach ($this->urls as $src) {

                $ch = curl_init($src);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 12_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $src = curl_exec($ch);

                @$dom->loadHTML($src);
                $xpath = new DOMXPath($dom);
                $rows = $xpath->query('//td[contains(@class, \'useragent\')]');
                foreach ($rows as $row) {
                    $items[] = $row->textContent;
                }
            }
        } catch (Throwable $exception) {
        }

        return $items;
    }
}