<?php
//stranica koja prikazuje pojedinu vijest
get_header();
?>
<article class="content px-3 py-5 p-md-5">
    <p>Single.php</p>
    <?php
    //omotavanje vijesti HTML kodom content-single.php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'single');
        }
    }
    ?>
</article>
<?php
get_footer();
?>