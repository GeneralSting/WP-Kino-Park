<!--izgled svih stranica osim naslovne-->
<?php
//header.php
get_header();
?>
<article class="content px-3 py-5 p-md-5">
    <?php
    //ako postoje stranice omotaj ih HTML kodom skripte content-page.php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'page');
        }
    }
    ?>
</article>
<?php
//footer.php
get_footer();
?>