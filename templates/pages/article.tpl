<article class="article-page">
    <header class="article-page__header">
        <h1 class="article-page__title">{$article.title|escape}</h1>
        <div class="article-page__meta">
            {if $article.published_at}
                <time datetime="{$article.published_at|escape}" class="article-page__date">{$article.published_at|date_format:'%d.%m.%Y'}</time>
            {/if}
            <span class="article-page__views">{$article.views} просмотр{if $article.views == 1}а{elseif $article.views < 5}ы{/if}</span>
            {if $article.categories|@count > 0}
                <div class="article-page__categories">
                    {foreach $article.categories as $cat}
                        <a href="/category/{$cat.id}" class="article-page__category">{$cat.name|escape}</a>
                    {/foreach}
                </div>
            {/if}
        </div>
    </header>

    {if $article.image}
        <figure class="article-page__image">
            <img src="{$article.image|escape}" alt="{$article.title|escape}">
        </figure>
    {/if}

    {if $article.description}
        <div class="article-page__excerpt">{$article.description|escape}</div>
    {/if}

    <div class="article-page__content">
        {$article.content|escape|nl2br}
    </div>
</article>

{if $relatedArticles|@count > 0}
    <section class="related-articles">
        <h2 class="related-articles__title">Похожие статьи</h2>
        <div class="related-articles__grid">
            {foreach $relatedArticles as $relArticle}
                {include file='article-card.tpl' article=$relArticle}
            {/foreach}
        </div>
    </section>
{/if}