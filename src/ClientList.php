<?php
/**
 * Created by PhpStorm.
 * User: sumeeti
 * Date: 26/3/16
 * Time: 12:26 PM
 */

namespace hyper;
require_once 'curlHelper.php';

class ClientList extends \ArrayObject {
    public $headers;
    public function __construct($headers) {
        $this->setHeaders($headers);
    }

    public function setHeaders($headers) {
        $this->headers = $headers;
    }

    public function next() {
        preg_match( '/^link: (.*)$/im', $this->headers, $matches);
        $link_info = $matches[1];
        $links = explode( ',', $link_info );
        $nextpage = null;
        foreach ( $links as $link ) {
            if (preg_match( '/<(.*?)>; rel="next"$/', $link, $matches )) {
                $nextpage = $matches[1];
            }
        }
        $result = \Curl_Helper::curlGet($nextpage);
        return $result;
    }

    public function prev() {
        preg_match( '/^link: (.*)$/im', $this->headers, $matches);
        $link_info = $matches[1];
        $links = explode( ',', $link_info );
        $prevpage = null;
        foreach ( $links as $link ) {
            if (preg_match( '/<(.*?)>; rel="prev"$/', $link, $matches )) {
                $prevpage = $matches[1];
            }
        }
        $result = \Curl_Helper::curlGet($prevpage);
        return $result;
    }
} 