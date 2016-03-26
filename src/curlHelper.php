<?php
/**
 * Created by PhpStorm.
 * User: sumeeti
 * Date: 26/3/16
 * Time: 9:43 PM
 */

class Curl_Helper {
    public static function curlGet($url) {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_USERAGENT      => "Chrome/31.0.1700.0",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false
        );

        $curl = curl_init($url);
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($content, 0, $header_size);
        $body = substr($content, $header_size);
        $body = json_decode($body, false);
        if(is_array($body)) {
            $result = new \hyper\ClientList($header);
            foreach($body as $b) {
                $result[] = new \hyper\client($b->url, json_encode($b), $header);
            }
        } else {
            $result = new \hyper\client($url, json_encode($body), $header);
        }
        return $result;
    }
}