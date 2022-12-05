<form role="search" method="get" class="search-form" action="<?php echo ('http://localhost/wp/wp_kinoPark/'); ?>">
    <input type="search" class="search-field" placeholder="Suchen …" value="<?php echo get_search_query() ?>" name="s"
        title="Suche nach:" />
    <input type="submit" class="search-submit" value="Suchen" />
</form>