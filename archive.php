<?php
get_header();
?>
<article class="content px-3 py-5 p-md-5 post-article">
    <p>Archive.php</p>
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            //svaku vijest obgrli archive dokumentom koji sadrzi HTML kod
            get_template_part('template-parts/content', 'archive');
        }
    }
    //paginacija
    ?>
    <div class="container">
        <div class="row"></div>
            <div class="col-md-6 offset-md-2">
            <?php
            the_posts_pagination();
            ?>
            </div>
        </div>
    </div>
</article>
<?php
get_footer();
?>