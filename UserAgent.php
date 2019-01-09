<?php
/**
 * Created for IG Monitoring.
 * User: jakim <pawel@jakimowski.info>
 * Date: 11.01.2018
 */

namespace jakim\ua;


class UserAgent
{
    public $default = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36';

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
        try {
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
        } catch (\Throwable $exception) {
            if (empty($items)) {
                $items[] = $this->default;
            }
        }

        return $items;
    }
}