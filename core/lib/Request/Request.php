<?php

namespace Scarpa\lib\Request;

class Request {
    protected $url;
    private $method;
    protected $data;
    protected $headers;

    public function __construct($url) {
        $this->url      = $url;
        $this->method   = 'GET'; // default
        $this->data     = [];
        $this->headers  = [];
    }

    public function setUrl($url) {
        if($this->url === null){
            $this->url = $url;
        }
    }

    public function setMethod($method){
        if($this->method === 'GET' || $this->method === null){
            $this->method = strtoupper($method);
        }
    }

    public function withMethod($method) {
        $this->method = strtoupper($method);
        return $this;
    }

    public function withData($data) {
        $this->data = $data;
        return $this;
    }

    public function withHeaders($headers) {
        $this->headers = $headers;
        return $this;
    }

    public function send() {
        $ch = curl_init($this->url);

        if ($this->method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
        }

        // Set additional headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        // Return response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return false; // Error occurred
        }

        curl_close($ch);
        return $response;
    }
}

// Example usage:
// $request = new Request('https://api.example.com');
// $response = $request
//     ->withMethod('GET')
//     ->withHeaders(['Authorization: Bearer YOUR_TOKEN'])
//     ->send();

// if ($response) {
//     echo $response;
// } else {
//     echo 'Request failed.';
// }
