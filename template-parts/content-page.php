<!--datoteku poziva page.php, vraca sadrzaj stranice obgrljen kontrainer elementom-->
<div class="container">
    <div class="row">
        <!--bootstrap grid za prikaz pojedine stranice, md 10 centriramo-->
        <div class="col-md-10 offset-md-1 site-page">
            <?php
            the_content();
            ?>
        </div>
    </div>
</div>