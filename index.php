<?php

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/core/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer autoloader...
require __DIR__.'/core/vendor/autoload.php';

// Bootstrap Laravel...
$app = require_once __DIR__.'/core/bootstrap/app.php';

// Set up a custom error and exception trap to catch and display any errors directly
set_exception_handler(function (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "=== ROOT APPLICATION EXCEPTION ===\n\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
    exit(1);
});

// Capture and handle request
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::capture();

try {
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    http_response_code(500);
    header('Content-Type: text/plain');
    echo "=== KERNEL CAUGHT EXCEPTION ===\n\n";
    echo "Class: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " (Line: " . $e->getLine() . ")\n\n";
    echo "Stack Trace:\n" . $e->getTraceAsString();
    exit(1);
}
