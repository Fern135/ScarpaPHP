<?php 

namespace Oracle\template\templater;

use Oracle\lib\util\Util;
use Exception;

class Templater extends Util {
    private $template;
    private $data = [];

    public function __construct() {
        $this->template = null;
    }

    public function setTemplate($template){
        if($this->template === null){
            $this->template = $template;
        }

        return false;
    }

    public function getTemplate(){
        if($this->template !== null){
            return $this->template;
        }

        return null;
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
    }

    public function render() {
        try{
            $rendered = $this->template;
            
            foreach ($this->data as $key => $value) {
                $placeholder = "{{ $key }}"; // have the data be space like {{ data }}
                $rendered = str_replace($placeholder, $value, $rendered);
            }
            
            return $rendered;

        }catch(Exception $error){
            return $error;
        }
    }
}

// Example usage:
// $template = new TemplateRenderer("Hello, {{ name }}! Your age is {{ age }}.");
// $template->set("name", "John");
// $template->set("age", 30);
// $result = $template->render();
// echo $result;
