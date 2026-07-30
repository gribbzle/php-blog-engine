<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticleModel;

class ArticleController extends Controller
{
    public function show(string $id): void
    {
        $articleId = $this->validateId($id);
        if ($articleId === null) {
            $this->render404();
            return;
        }

        $articleModel = new ArticleModel();
        $article = $articleModel->getById($articleId);

        if ($article === null) {
            $this->render404();
            return;
        }

        $articleModel->incrementViews($articleId);

        $relatedArticles = $articleModel->getRelatedArticles($articleId, 3);

        $this->renderLayout('article.tpl', [
            'title' => $article['title'] . ' - Blog',
            'article' => $article,
            'relatedArticles' => $relatedArticles,
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