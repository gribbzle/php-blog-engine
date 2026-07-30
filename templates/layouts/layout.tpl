<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'Blog'}</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">Блог</a>
            <nav class="header__nav">
                <a href="/" class="header__link">Главная</a>
            </nav>
        </div>
    </header>

    <main class="main">
        <div class="main-container">
            {include file=$content_template}
        </div>
    </main>

    <footer class="footer">
        <div class="footer__inner">
            <p class="footer__copyright">&copy; {$smarty.now|date_format:"%Y"} Blog Engine</p>
        </div>
    </footer>
</body>
</html>