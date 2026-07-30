<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ArticleModel;

class CategoryController extends Controller
{
    private const PER_PAGE = 10;

    public function show(string $id): void
    {
        $categoryId = $this->validateId($id);
        if ($categoryId === null) {
            $this->render404();
            return;
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->getById($categoryId);

        if ($category === null) {
            $this->render404();
            return;
        }

        $sort = $_GET['sort'] ?? 'date';
        $allowedSorts = ['date', 'views'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'date';
        }

        $page = max(1, (int) ($_GET['page'] ?? 1));

        $articleModel = new ArticleModel();
        $articles = $articleModel->getByCategoryId($categoryId, $sort, $page, self::PER_PAGE);
        $totalArticles = $articleModel->getTotalByCategoryId($categoryId);
        $totalPages = (int) ceil($totalArticles / self::PER_PAGE);

        if ($page > $totalPages && $totalPages > 0) {
            $this->render404();
            return;
        }

        $this->renderLayout('category.tpl', [
            'title' => $category['name'] . ' - Blog',
            'category' => $category,
            'articles' => $articles,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages,
            'categoryId' => $categoryId,
        ]);
    }

    private function validateId(string $id): ?int
    {
        $id = (int) $id;
        return $id > 0 ? $id : null;
    }

    private function render404(): void
    {
        http_response_code(404);
        $this->renderLayout('404.tpl', [
            'title' => '404 - Not Found',
        ]);
    }
}