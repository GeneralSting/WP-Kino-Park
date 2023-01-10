<?php
get_header();
function abc($selected_taxonomies)
{
    // Query the movies
    $args = array(
        //mjenjano je, mogući error
        'post_type' => 'film',
        'meta_key' => 'filter_movie_date',
        'orderby' => 'meta_value',
        'order' => 'DESC'

    );
    $movies_query = new WP_Query($args);
    ?>
    <div class="movies-query-wrapper">
        <?php if ($movies_query->have_posts()): ?>
            <?php while ($movies_query->have_posts()):
            $movies_query->the_post();
            $movie_date = get_post_meta(get_the_ID(), 'movie_date', true);
            $movie_time = get_post_meta(get_the_ID(), 'movie_time', true);
            $movie_duration = get_post_meta(get_the_ID(), 'movie_duration', true);
            $movie_price = get_post_meta(get_the_ID(), 'movie_price', true);
            $movie_director = get_post_meta(get_the_ID(), 'movie_director', true);
            $movie_screenwriter = get_post_meta(get_the_ID(), 'movie_screenwriter', true);
            $movie_roles = get_post_meta(get_the_ID(), 'movie_roles', true);

            $parts = explode(":", $movie_duration);
            $hours = intval($parts[0]);
            $minutes = intval($parts[1]);
            $movie_duration_minutes = $hours * 60 + $minutes;



            // Get the current post type
            $post_type = get_post_type();

            // Get an array of taxonomy names for the post type
            $taxonomies = get_object_taxonomies($post_type, 'names');

            // Loop through the taxonomies and get the terms for each one
            $filter_movie_date = get_post_meta(get_the_ID(), 'filter_movie_date', true);
            //provjera datuma usporava stranicu
            if (strtotime($filter_movie_date) > time()) {
                ?>
                    <div class="row movie-wrapper">
                        <div class="col-md-3">
                            <h2 class="movie-title ml-2" style="color: white;">
                                <?php the_title(); ?>
                            </h2>
                            <img class="ml-2 img-fluid post-thumb d-none d-md-flex post-thumbnail"
                                src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="image"
                                style="width: 200px; height: 200px; margin-bottom: 16px;">
                            <p>Trajanje: <?php echo '<b>' . $movie_duration_minutes . ' minuta </b>'; ?></p>
                            <p>Cijena: <b style="margin-left: 12px;">
                                    <?php echo $movie_price; ?>&#8364;
                                </b></p>
                        </div>
                        <div class="col-md-4 movie-details-wrapper">
                            <p>Datum: <?php echo '<b style="margin-left:6px;">' . $movie_date . '</b>'; ?></p>
                            <p>Vrijeme: <?php echo '<b>' . $movie_time . '</b>'; ?></p>
                            <?php
                            foreach ($taxonomies as $taxonomy) {
                                $terms = wp_get_post_terms(get_the_ID(), $taxonomy);
                                if ($taxonomy == "država") {
                                    foreach ($terms as $term) {
                                        echo '<p>Država: <b style="margin-left:6px;">' . $term->name . '</b></p>';
                                    }
                                }
                            }
                            foreach ($taxonomies as $taxonomy) {
                                $terms = wp_get_post_terms(get_the_ID(), $taxonomy);
                                if ($taxonomy == "žanr") {
                                    echo '<h5>Žanrovi: </h5>';
                                    echo '<ul>';
                                    foreach ($terms as $term) {
                                        echo '<li>' . $term->name . '</li>';
                                    }
                                    echo '</ul>';
                                }
                                if ($taxonomy == "tip_publike") {
                                    echo '<h5>Namjenjenoj publici: </h5>';
                                    echo '<ul>';
                                    foreach ($terms as $term) {
                                        echo '<li>' . $term->name . '</li>';
                                    }
                                    echo '</ul>';
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-4 movie-optional-details">
                            <div>
                                <p>Redatelj: <?php echo '<b style="margin-left:7px;">' . $movie_director . '</b>'; ?></p>
                                <p>Scenarist: <?php echo '<b style="margin-left:2px;">' . $movie_screenwriter . '</b>'; ?></p>
                                <p>Uloge: <?php echo '<b style="margin-left:22px;">' . $movie_roles . '</b>'; ?></p>
                            </div>
                            <div class="movie-plot-wrapper">
                                <?php

                                $movie_plot = get_the_content();
                                $movie_title = get_the_title();
                                $movie_plot_short = explode(' ', $movie_plot);
                                if (count($movie_plot_short) > 30) {
                                    $movie_plot_short = array_slice($movie_plot_short, 0, 30);
                                    $movie_plot_short = implode(' ', $movie_plot_short);
                                    $movie_plot_short .= "...";
                                } else {
                                    $movie_plot_short = array_slice($movie_plot_short, 0, 30);
                                    $movie_plot_short = implode(' ', $movie_plot_short);
                                }

                                ?>
                                <?php echo $movie_plot_short; ?>
                            </div>
                            <button class="btn btn-success btn-large movie-btn-reservation" data-toggle="modal" data-target="#myModal"
                                movie-title="<?php echo $movie_title ?>">Rezerviraj</button>
                        </div>
                    </div>
                    <?php
            }
        endwhile; ?>
            <?php else: ?>
            <p>
                <?php _e('Nema filmova za prikaz'); ?>
            </p>
            <?php endif;
            wp_reset_postdata();
}

if (isset($_POST['selected_taxonomies'])) {
    abc(json_decode($_POST['selected_taxonomies']));
}
get_footer();
?>