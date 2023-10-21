<?php

function runTests($directory) {
    $iterator  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    $testFiles = new RegexIterator($iterator, '/^.+\.test\.php$/i', RecursiveRegexIterator::GET_MATCH);

    foreach ($testFiles as $testFile) {
        $testFile = current($testFile);
        
        echo "Running test: $testFile\n";
        ob_start();
        include $testFile;

        $output = ob_get_clean();
        
        if (empty($output)) {
            echo "Test Passed.\n";
        } else {
            echo "Test Failed:\n$output\n";
        }
    }
}

runTests('tests'); // Change 'tests' to the directory where your test files are located.
