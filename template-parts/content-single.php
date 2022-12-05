<!--Ovu datoteku poziva single.php, za svaku vijest, omotaj ju HTML kodom ove datoteke-->
<!--Sluzi za omotavanje sadrzaja vijesti u njenom potpunom prikazu-->
<!--prikaz pojedine vijesti u single.php-->
<div class="container">
    <!--prikaz datum vijesti, broj komentara-->
    <div class="row justify-content-md-center">
        <div class="col-md-auto single-post-metadata mb-4">
            <span class="date">
                <!--datum-->
                <?php the_date(); ?>
            </span>
            <!--prikaz oznaka koje vijest sadrzi-->
            <?php
            the_tags('<span class="tag"><i class="fa fa-tag"></i>', '</span><span class="tag"><i class="fa fa-tag"></i>', '</span>')
                ?>
            </span>
            <!--broj komentara-->
            <span class="comment"><a href="#comments"><i class='fa fa-comment'></i>
                    <?php comments_number() ?>
                </a>
            </span>
        </div>
    </div>
    <div class="row justify-content-md-center">
        <div class="col-md-8 single-post">
            <h1 style="text-align: center; margin: 1rem;">
                <!--naziv vijesti-->
                <?php the_title(); ?>
            </h1>
            <hr />

            <?php
            //sadrzaj vijesti
            the_content();
            //sekcija za pisanje komentara
            comments_template();
            ?>
        </div>
    </div>
</div>