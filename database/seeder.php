<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Faker\Factory;
use App\Database\Connection;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$faker = Factory::create('ru_RU');
$pdo = Connection::getInstance();

echo "Starting database seeding...\n";

try {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $pdo->exec('TRUNCATE TABLE article_category');
    $pdo->exec('TRUNCATE TABLE articles');
    $pdo->exec('TRUNCATE TABLE categories');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    echo "Tables truncated.\n";
} catch (\PDOException $e) {
    echo "Error truncating tables: " . $e->getMessage() . "\n";
    exit(1);
}

$categoryNames = [
    'Технологии' => 'Статьи о современных технологиях, гаджетах и инновациях',
    'Программирование' => 'Уроки, советы и лучшие практики разработки',
    'Дизайн' => 'UI/UX дизайн, графика, вдохновение',
    'Бизнес' => 'Стартапы, маркетинг, управление проектами',
    'Наука' => 'Научные открытия, исследования, технологии будущего',
    'Образование' => 'Обучение, курсы, саморазвитие',
    'Здоровье' => 'Здоровый образ жизни, медицина, спорт',
    'Путешествия' => 'Маршруты, советы путешественников, фото',
];

$categoryIds = [];

echo "Creating categories...\n";
foreach ($categoryNames as $name => $description) {
    $stmt = $pdo->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
    $stmt->execute([$name, $description]);
    $categoryIds[] = $pdo->lastInsertId();
}
echo "Created " . count($categoryIds) . " categories.\n";

$imageUrls = [
    'https://picsum.photos/seed/tech1/800/400',
    'https://picsum.photos/seed/code1/800/400',
    'https://picsum.photos/seed/design1/800/400',
    'https://picsum.photos/seed/biz1/800/400',
    'https://picsum.photos/seed/science1/800/400',
    'https://picsum.photos/seed/edu1/800/400',
    'https://picsum.photos/seed/health1/800/400',
    'https://picsum.photos/seed/travel1/800/400',
    'https://picsum.photos/seed/tech2/800/400',
    'https://picsum.photos/seed/code2/800/400',
];

$articleCount = 30;

echo "Creating articles...\n";
$articleIds = [];

for ($i = 0; $i < $articleCount; $i++) {
    $title = $faker->sentence(rand(4, 8));
    $description = $faker->paragraph(rand(2, 4));
    $content = implode("\n\n", $faker->paragraphs(rand(5, 10)));
    $image = $imageUrls[array_rand($imageUrls)];
    $views = rand(0, 1000);
    $publishedAt = $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s');

    $stmt = $pdo->prepare(
        'INSERT INTO articles (image, title, description, content, views, published_at) VALUES (?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute([$image, $title, $description, $content, $views, $publishedAt]);
    $articleIds[] = $pdo->lastInsertId();
}
echo "Created " . count($articleIds) . " articles.\n";

echo "Creating article-category relationships...\n";
$relationshipCount = 0;
foreach ($articleIds as $articleId) {
    $numCategories = rand(1, 3);
    $selectedCategories = $faker->randomElements($categoryIds, $numCategories);

    foreach ($selectedCategories as $categoryId) {
        $stmt = $pdo->prepare('INSERT INTO article_category (article_id, category_id) VALUES (?, ?)');
        $stmt->execute([$articleId, $categoryId]);
        $relationshipCount++;
    }
}
echo "Created $relationshipCount relationships.\n";

echo "\nSeeding completed successfully!\n";
echo "Categories: " . count($categoryIds) . "\n";
echo "Articles: " . count($articleIds) . "\n";
echo "Relationships: $relationshipCount\n";