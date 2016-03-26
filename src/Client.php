<?php
/**
 * Created by PhpStorm.
 * User: sumeeti
 * Date: 22/3/16
 * Time: 10:11 PM
 */

namespace hyper;
require __DIR__ . '/../vendor/autoload.php';
use Rize\UriTemplate;

class Client {

    public $uri = "";
    public $body = "";
    public $headers = "";
    function __construct($host, $body=null, $header=null) {

        $this->setUri($host);
        $this->setBody($body);
        $this->setHeaders($header);
    }

    public function setUri($uri) {
        $this->uri = $uri;
    }

    public function getUri() {
        return $this->uri;
    }

    public function setBody($body) {
        $this->body = $body;
    }
    public function setHeaders($headers) {
        $this->headers = $headers;
    }

    public function __call($name, $arguments) {
        $urit = new UriTemplate($this->uri);
        $head = '/'.$name;
        $tail = array();
        foreach($arguments as $i => $argument) {
            $head .= '/{arg'.$i.'}';
            $tail['arg'.$i] = $argument;
        }
        $expanded = $urit->expand($head, $tail);
        $b = json_decode($this->body, false);
        if(isset($b->{$name})) {
            return json_encode($b->{$name});
        } else {
            $result = \Curl_Helper::curlGet($expanded);
            return $result;
        }

    }

    public function next() {
        preg_match( '/^link: (.*)$/im', $this->headers, $matches);
        var_dump($matches);
    }
}