<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\HomeController;
use App\Controllers\CategoryController;
use App\Controllers\ArticleController;
use App\Controllers\ErrorController;
use App\Router;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Custom error handler for PHP errors
set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    throw new \ErrorException($message, 0, $severity, $file, $line);
});

// Custom exception handler for uncaught exceptions
set_exception_handler(function (\Throwable $e): void {
    // Log the error
    $logMessage = sprintf(
        "[%s] %s: %s in %s:%d\nStack trace:\n%s\n---\n",
        date('Y-m-d H:i:s'),
        get_class($e),
        $e->getMessage(),
        $e->getFile(),
        $e->getLine(),
        $e->getTraceAsString()
    );
    $logFile = __DIR__ . '/../storage/logs/error.log';
    @file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);

    // Don't show error details in production
    $debug = ($_ENV['APP_DEBUG'] ?? 'false') === 'true';

    http_response_code(500);
    
    if ($debug) {
        // Show detailed error in debug mode
        header('Content-Type: text/html; charset=utf-8');
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>500 - Server Error</title>';
        echo '<style>body{font-family:monospace;padding:2rem;max-width:800px;margin:0 auto;}';
        echo 'h1{color:#c00;}pre{background:#f5f5f5;padding:1rem;overflow:auto;}</style></head><body>';
        echo '<h1>500 - Server Error</h1>';
        echo '<p><strong>Class:</strong> ' . htmlspecialchars(get_class($e)) . '</p>';
        echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ':' . $e->getLine() . '</p>';
        echo '<h2>Stack Trace</h2><pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        echo '</body></html>';
    } else {
        // Render 500 template
        try {
            $controller = new ErrorController();
            $controller->serverError();
        } catch (\Throwable $renderError) {
            // Fallback if template rendering fails
            header('Content-Type: text/html; charset=utf-8');
            echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>500 - Server Error</title></head><body>';
            echo '<h1>500 - Internal Server Error</h1>';
            echo '<p>An unexpected error occurred. Please try again later.</p>';
            echo '<a href="/">Return to homepage</a>';
            echo '</body></html>';
        }
    }
});

$router = new Router();

$router->get('/', function () {
    $controller = new HomeController();
    $controller->index();
});

$router->get('/category/{id}', function (string $id) {
    $controller = new CategoryController();
    $controller->show($id);
});

$router->get('/article/{id}', function (string $id) {
    $controller = new ArticleController();
    $controller->show($id);
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$router->dispatch($method, $uri);