<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CategoryModel;

class HomeController extends Controller
{
    public function index(): void
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getWithLatestArticles(3);

        $this->renderLayout('home.tpl', [
            'title' => 'Home - Blog',
            'categories' => $categories,
        ]);
    }
}
