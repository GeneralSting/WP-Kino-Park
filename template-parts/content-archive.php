<!--ovu datoteku poziva archive.php tako da ce za svaku viejst proci kroz ovu datoteku, te ce se svaka vijest obloziti HTML kodom ove datoteke-->
<!--Sluzi za omotavanje sadrzaja vijesti u njenom potpunom prikazu-->
<!--prikaz pojedinacne vijesti u archive.php, ne odnosi se na prikaz pojedinog sadrzaja vijesti, to radi content-archive.php-->
<!--svaka vijest ce zasebno sadrzavati kod ispod, container sadrzava div.media gdje se pocinje stvarati vijest-->
<div class="container single-post-archive">
    <div class="post mb-5">
        <div class="media">
            <!--thumbnail, slika-->
            <img class="mr-3 img-fluid post-thumb d-none d-md-flex post-thumbnail" src="<?php the_post_thumbnail_url('thumbnail'); ?>"
                alt="image">
            <!--sadrzava sve ostalo osim slike-->
            <div class="media-body">
                <div class="media-body">
                    <h3 class="title mb-1 single-title-archive">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h3>
                    <!--prikaz datum kreirane vijesti, koliko je potrebno da se procita, komentare-->
                    <div class="meta mb-1"><span class="date">
                            <?php the_date(); ?>
                        </span><span class="time">5-10 min
                            read</span><span class="comment"><a href="#">
                                <?php comments_number(); ?>
                            </a></span></div>
                    <div class="intro">
                        <!--tekstualni sadrzaj vijesti-->
                        <?php the_excerpt(); ?>
                    </div>
                    <!--dodatna poveznica za otvaranje vijesti-->
                    <a class="more-link" href="<?php the_permalink(); ?>">Read more &rarr;</a>
                </div>
                <!--//media-body-->
            </div>
            <!--//media-->
        </div>
    </div>
</div>