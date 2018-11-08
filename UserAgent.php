<?php
/**
 * Created for IG Monitoring.
 * User: jakim <pawel@jakimowski.info>
 * Date: 11.01.2018
 */

namespace jakim\ua;


class UserAgent
{
    public $default = 'Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 5 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko; googleweblight) Chrome/38.0.1025.166 Mobile Safari/535.19';

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

            $ch = curl_init($src);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->default);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $src = curl_exec($ch);

            @$dom->loadHTML($src);
            $xpath = new \DOMXPath($dom);
            $rows = $xpath->query('//td[contains(@class, \'useragent\')]');
            foreach ($rows as $row) {
                $items[] = $row->textContent;
            }
        }

        return $items;
    }
}