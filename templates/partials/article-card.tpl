<div class="article-card">
    {if $article.image}
        <a href="/article/{$article.id}" class="article-card__image-link">
            <img src="{$article.image|escape}" alt="{$article.title|escape}" class="article-card__image">
        </a>
    {/if}
    <div class="article-card__content">
        <h3 class="article-card__title">
            <a href="/article/{$article.id}">{$article.title|escape}</a>
        </h3>
        {if $article.description}
            <p class="article-card__excerpt">{$article.description|escape|truncate:150}</p>
        {/if}
        <div class="article-card__meta">
            {if $article.published_at}
                <time datetime="{$article.published_at|escape}" class="article-card__date">{$article.published_at|date_format:'%d.%m.%Y'}</time>
            {/if}
            <span class="article-card__views">{$article.views} просмотр{if $article.views == 1}а{elseif $article.views < 5}ы{/if}</span>
        </div>
    </div>
</div>