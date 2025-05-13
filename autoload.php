<?php
// Define the autoloader function
function autoload($className) {
    // Define the base directory for the project
    $baseDir = __DIR__ . '/src/';

    // Convert the class name to a file path (assuming PSR-4 autoloading standard)
    $file = $baseDir . str_replace('\\', '/', $className) . '.php';

    // Check if the file exists and include it
    if (file_exists($file)) {
        require_once $file;
    }
}

// Register the autoloader
spl_autoload_register('autoload');
