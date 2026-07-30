{if $total > 1}
    <nav class="pagination" aria-label="Pagination">
        {if $current > 1}
            <a class="pagination__link" href="/category/{$categoryId|escape}?sort={$sort|escape}&page={$current - 1}" rel="prev">← Назад</a>
        {/if}

        {for $i = 1 to $total}
            {if $i == $current}
                <span class="pagination__link pagination__link--current">{$i}</span>
            {elseif $i == 1 || $i == $total || ($i >= $current - 1 && $i <= $current + 1)}
                <a class="pagination__link" href="/category/{$categoryId|escape}?sort={$sort|escape}&page={$i}">{$i}</a>
            {elseif $i == $current - 2 || $i == $current + 2}
                <span class="pagination__ellipsis">…</span>
            {/if}
        {/for}

        {if $current < $total}
            <a class="pagination__link" href="/category/{$categoryId|escape}?sort={$sort|escape}&page={$current + 1}" rel="next">Вперёд →</a>
        {/if}
    </nav>
{/if}