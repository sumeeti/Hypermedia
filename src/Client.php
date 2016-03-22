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
    function __construct($host, $body, $header) {

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
        var_dump($expanded);
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

        $curl = curl_init($expanded);
        curl_setopt_array($curl, $options);
        $content = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $header = substr($content, 0, $header_size);
        $body = substr($content, $header_size);
        $body = json_decode($body, false);
        if(is_array($body)) {
            foreach($body as $b) {
                $result[] = new client($b->url, json_encode($b), $header);
            }
        } else {
            $result = new client($expanded, json_encode($body), $header);
        }
        return $result;
    }

}