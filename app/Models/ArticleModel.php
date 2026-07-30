<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

class ArticleModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function getById(int $id): ?array
    {
        $sql = '
            SELECT a.id, a.image, a.title, a.description, a.content, a.views, a.published_at, a.created_at, a.updated_at
            FROM articles a
            WHERE a.id = ?
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $article = $stmt->fetch();

        if (!$article) {
            return null;
        }

        $article['categories'] = $this->getCategoriesByArticleId($id);

        return $article;
    }

    public function getByCategoryId(int $categoryId, string $sort, int $page, int $perPage): array
    {
        $allowedSorts = ['date', 'views'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'date';

        $orderBy = $sort === 'views' ? 'a.views DESC' : 'a.published_at DESC';
        $offset = ($page - 1) * $perPage;

        $sql = "
            SELECT a.id, a.image, a.title, a.description, a.published_at, a.views
            FROM articles a
            INNER JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = ?
            ORDER BY {$orderBy}
            LIMIT ? OFFSET ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(3, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTotalByCategoryId(int $categoryId): int
    {
        $sql = '
            SELECT COUNT(*) as total
            FROM articles a
            INNER JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = ?
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$categoryId]);
        $result = $stmt->fetch();

        return (int) ($result['total'] ?? 0);
    }

    public function getRelatedArticles(int $articleId, int $limit = 3): array
    {
        $sql = '
            SELECT DISTINCT a.id, a.image, a.title, a.description, a.published_at, a.views
            FROM articles a
            INNER JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id IN (
                SELECT category_id FROM article_category WHERE article_id = ?
            )
            AND a.id != ?
            ORDER BY a.published_at DESC
            LIMIT ?
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $articleId, PDO::PARAM_INT);
        $stmt->bindValue(2, $articleId, PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $sql = 'UPDATE articles SET views = views + 1 WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    private function getCategoriesByArticleId(int $articleId): array
    {
        $sql = '
            SELECT c.id, c.name
            FROM categories c
            INNER JOIN article_category ac ON c.id = ac.category_id
            WHERE ac.article_id = ?
            ORDER BY c.name ASC
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$articleId]);

        return $stmt->fetchAll();
    }
}