<?php
//header.php
get_header();
?>
<article class="content px-3 py-5 p-md-5">
    <h1 style="color: white; margin-top: 10%">Rezultati Vašeg pretraživanja:</h1>
    <?php
    //rezultat pretrazivanje ce biti prikazano u obliku vijestu kao sto je prikazano u archive.php
    //to ce odgovarati prikazu vijesti, ali postoji mogucnost da se stranice nece najbolje prilagoditi
    //stranice ce takoder biti prikazane u obliku vijesti
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            get_template_part('template-parts/content', 'archive');
        }
    }
    ?>
</article>
<?php
//footer.php
get_footer();
?>