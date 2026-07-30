<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use PDO;

class CategoryModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function getAllWithArticleCount(): array
    {
        $sql = '
            SELECT c.id, c.name, c.description, c.created_at, c.updated_at, COUNT(a.id) AS articles_count
            FROM categories c
            INNER JOIN article_category ac ON c.id = ac.category_id
            INNER JOIN articles a ON ac.article_id = a.id
            GROUP BY c.id, c.name, c.description, c.created_at, c.updated_at
            HAVING COUNT(a.id) > 0
            ORDER BY c.name ASC
        ';

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $sql = 'SELECT id, name, description, created_at, updated_at FROM categories WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        return $result ?: null;
    }

    public function getWithLatestArticles(int $limit = 3): array
    {
        $sql = '
            SELECT c.id, c.name, c.description, c.created_at, c.updated_at
            FROM categories c
            INNER JOIN article_category ac ON c.id = ac.category_id
            INNER JOIN articles a ON ac.article_id = a.id
            GROUP BY c.id, c.name, c.description, c.created_at, c.updated_at
            HAVING COUNT(a.id) > 0
            ORDER BY c.name ASC
        ';

        $stmt = $this->pdo->query($sql);
        $categories = $stmt->fetchAll();

        foreach ($categories as &$category) {
            $category['latest_articles'] = $this->getLatestArticlesByCategoryId($category['id'], $limit);
        }

        return $categories;
    }

    private function getLatestArticlesByCategoryId(int $categoryId, int $limit): array
    {
        $sql = '
            SELECT a.id, a.image, a.title, a.description, a.published_at, a.views
            FROM articles a
            INNER JOIN article_category ac ON a.id = ac.article_id
            WHERE ac.category_id = ?
            ORDER BY a.published_at DESC
            LIMIT ?
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}