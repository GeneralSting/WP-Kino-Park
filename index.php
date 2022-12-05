<!--Datoteka index.php je prva datoteka (skripta) koja će pokreće pristupanjem javnoj stranici-->
<!-- 
*   This is the most generic template file in a WordPress theme
*   and one of the two required files for a theme (the other being style.css).
*   It is used to display a page when nothing more specific matches a query.
*   E.g., it puts together the home page when no front-page.php/page.php file exists.
-->
<?php
//header.php
get_header();
?>
<article class="content px-3 py-5 p-md-5">
    <?php
    //prikaz svih vijesti
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'archive');
        }
    }
    ?>
    <?php
    //paginacija vijesti
    the_posts_pagination();
    ?>
</article>
<?php
//footer.php
get_footer();
?>