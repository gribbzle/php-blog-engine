<div class="home-page">
    <header class="home-page__header">
        <h1 class="home-page__title">Блог</h1>
        <p class="home-page__subtitle">Последние статьи по категориям</p>
    </header>

    {if $categories|@count > 0}
        {foreach $categories as $category}
            <section class="category-section">
                <header class="category-section__header">
                    <h2 class="category-section__title">{$category.name|escape}</h2>
                    {if $category.latest_articles|@count > 0}
                        <a href="/category/{$category.id}" class="category-section__view-all">Все статьи →</a>
                    {/if}
                </header>

                {if $category.latest_articles|@count > 0}
                    <div class="articles-grid category-section__articles">
                        {foreach $category.latest_articles as $article}
                            {include file='article-card.tpl' article=$article}
                        {/foreach}
                    </div>
                {else}
                    <p class="category-section__empty">Статей пока нет</p>
                {/if}
            </section>
        {/foreach}
    {else}
        <p class="home-page__empty">Категорий с статьями пока нет.</p>
    {/if}
</div>