<?php
/**
 * Created for IG Monitoring.
 * User: jakim <pawel@jakimowski.info>
 * Date: 11.01.2018
 */

namespace jakim\ua;


class UserAgent
{
    public $src = [
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/1',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/2',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/3',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/4',
        'https://developers.whatismybrowser.com/useragents/explore/software_type_specific/web-browser/5',
    ];

    public function random()
    {
        $items = $this->fetch();
        shuffle($items);

        return $items['0'];
    }

    public function fetch()
    {
        $items = [];
        $dom = new \DOMDocument();
        foreach ($this->src as $src) {
            @$dom->loadHTMLFile($src);
            $xpath = new \DOMXPath($dom);
            $rows = $xpath->query('//td[contains(@class, \'useragent\')]');
            foreach ($rows as $row) {
                $items[] = $row->textContent;
            }
        }

        return $items;
    }
}