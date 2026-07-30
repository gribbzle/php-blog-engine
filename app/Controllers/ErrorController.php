<?php

declare(strict_types=1);

namespace App\Controllers;

class ErrorController extends Controller
{
    public function serverError(): void
    {
        http_response_code(500);
        $this->renderLayout('500.tpl', [
            'title' => '500 - Server Error',
        ]);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->renderLayout('404.tpl', [
            'title' => '404 - Not Found',
        ]);
    }
}