<?php

class WebScraper {
    private $html;

    public function __construct() {
        $this->html = '';
    }

    public function loadHtml($url) {
        $this->html = file_get_contents($url);
    }

    public function findElementsByTag($tag) {
        $pattern = "/<$tag.*?>(.*?)<\/$tag>/si";
        preg_match_all($pattern, $this->html, $matches);

        return $matches[1];
    }

    public function findElementsByClass($className) {
        $pattern = "/class=['\"]$className['\"]/si";
        preg_match_all($pattern, $this->html, $matches);

        $elements = [];
        foreach ($matches[0] as $match) {
            $element = strip_tags($match);
            $elements[] = $element;
        }

        return $elements;
    }
}

// Example usage:
$scraper = new WebScraper();
$scraper->loadHtml("https://example.com");

// Find elements by tag (e.g., "a" for links)
$links = $scraper->findElementsByTag("a");
print_r($links);

// Find elements by class (e.g., "classname")
$elements = $scraper->findElementsByClass("classname");
print_r($elements);
