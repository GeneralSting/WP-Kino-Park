<?php
//header.php
get_header();
?>
<main>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-auto" id="front-page-content">
                <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post();
                        the_content();
                    }
                }
                ?>
            </div>
        </div>
</main>
<?php
//footer.php
get_footer();
?>