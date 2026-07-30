<div class="category-page">
    <header class="category-page__header">
        <h1 class="category-page__title">{$category.name|escape}</h1>
        {if $category.description}
            <p class="category-page__description">{$category.description|escape}</p>
        {/if}
    </header>

    <div class="category-page__controls">
        <form class="sort-form" method="get" action="">
            <label for="sort" class="visually-hidden">Сортировка</label>
            <select name="sort" id="sort" class="sort-form__select" onchange="this.form.submit()">
                <option value="date" {if $sort == 'date'}selected{/if}>По дате (новые)</option>
                <option value="views" {if $sort == 'views'}selected{/if}>По просмотрам</option>
            </select>
            <input type="hidden" name="page" value="{$page|escape}">
        </form>
    </div>

    <div class="articles-grid">
        {if $articles|@count > 0}
            {foreach $articles as $article}
                {include file='article-card.tpl' article=$article}
            {/foreach}
        {else}
            <p class="articles-grid__empty">В этой категории пока нет статей.</p>
        {/if}
    </div>

    {include file='pagination.tpl' current=$page total=$totalPages categoryId=$category.id sort=$sort}
</div>