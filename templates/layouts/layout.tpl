<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|default:'Blog'}</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/">Blog</a>
        </nav>
    </header>

    <main>
        {include file=$content_template}
    </main>

    <footer>
        <p>&copy; {$smarty.now|date_format:"%Y"} Blog Engine</p>
    </footer>
</body>
</html>
