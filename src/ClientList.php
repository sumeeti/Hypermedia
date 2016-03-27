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

    /**
     * @param $name - API name
     * @param $arguments - API parameters
     * @return array of Client objects
     */
    public function __call($name, $arguments) {
        preg_match( '/^link: (.*)$/im', $this->headers, $matches);
        $link_info = $matches[1];
        $links = explode( ',', $link_info );
        $relativepage = null;
        switch($name) {
            case 'next':
                foreach ( $links as $link ) {
                    if (preg_match( '/<(.*?)>; rel="next"$/', trim($link), $matches )) {
                        $relativepage = $matches[1];
                    }
                }
                break;

            case 'prev':
                foreach ( $links as $link ) {
                    if (preg_match( '/<(.*?)>; rel="prev"$/', trim($link), $matches )) {
                        $relativepage = $matches[1];
                    }
                }
                break;

            case 'first':
                foreach ( $links as $link ) {
                    if (preg_match( '/<(.*?)>; rel="first"$/', trim($link), $matches )) {
                        $relativepage = $matches[1];
                    }
                }
                break;

            case 'last':
                foreach ( $links as $link ) {
                    if (preg_match( '/<(.*?)>; rel="last"$/', trim($link), $matches )) {
                        $relativepage = $matches[1];
                    }
                }
                break;
        }
        $result = \Curl_Helper::curlGet($relativepage);
        return $result;
    }
} 