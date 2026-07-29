<?php

declare(strict_types=1);

namespace App\Controllers;

use Smarty;

abstract class Controller
{
    protected Smarty $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir([
            'layouts' => __DIR__ . '/../../templates/layouts',
            'pages' => __DIR__ . '/../../templates/pages',
            'partials' => __DIR__ . '/../../templates/partials',
        ]);
        $this->smarty->setCompileDir(__DIR__ . '/../../storage/templates_c');
        $this->smarty->setCacheDir(__DIR__ . '/../../storage/cache');
        $this->smarty->setConfigDir(__DIR__ . '/../../storage/configs');
    }

    protected function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }

    protected function renderLayout(string $contentTemplate, array $data = []): void
    {
        $this->smarty->assign('content_template', $contentTemplate);
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display('layout.tpl');
    }
}
