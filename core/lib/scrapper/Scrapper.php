<?php

class WebScraper {
    private $html;

    public function __construct() {
        $this->html = '';
    }

    public function __destruct(){
        $this->html = '';
    }

    public function loadHtml($url) {
        $this->html = file_get_contents($url);
    }

    public function selectElement($selector) {
        $pattern = "/<$selector.*?>(.*?)<\/$selector>/si";
        preg_match($pattern, $this->html, $matches);
        return $matches[1] ?? '';
    }

    public function findById($id) {
        $pattern = "/id=['\"]" . preg_quote($id, '/') . "['\"]>(.*?)<\/.*?>/si";
        preg_match($pattern, $this->html, $matches);
        return $matches[1] ?? '';
    }
    

    public function findByClass($className) {
        $pattern = "/class=['\"]" . preg_quote($className, '/') . "['\"]>(.*?)<\/.*?>/si";
        preg_match_all($pattern, $this->html, $matches);
        return $matches[1] ?? [];
    }
    
}


// Example usage:
// $scraper = new WebScraper();
// $scraper->loadHtml("https://example.com");

// Find elements by tag (e.g., "a" for links)
// $links = $scraper->findElementsByTag("a");
// echo ($links);

// Find elements by class (e.g., "classname")
// $elements = $scraper->findElementsByClass("classname");
// echo ($elements);
