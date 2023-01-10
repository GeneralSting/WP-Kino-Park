<?php
/*
Template Name: Unique Page
*/
get_header();
?>
<div class="overlay">Učitavanje</div>
<main class="main-statistics">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <h1 class="movie-welcome-title">Statistika</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 statistics-movies animated-border-movies">
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <h1>
                            <?php
                            $flag = true;
                            $args = array(
                                //mjenjano je, mogući error
                                'post_type' => 'film',
                                'posts_per_page' => -1,
                                'meta_key' => 'filter_movie_date',
                                'orderby' => 'meta_value',
                                'order' => 'DESC'

                            );
                            $movie_counter = 0;
                            $movies_query = new WP_Query($args);
                            ?>
                            <div class="movies-statistics-wrapper">
                                <?php if ($movies_query->have_posts()): ?>
                                    <?php while ($movies_query->have_posts()):
                                        $movies_query->the_post();
                                        $movie_counter++;
                                        $movie_date = get_post_meta(get_the_ID(), 'movie_date', true);
                                        $movie_time = get_post_meta(get_the_ID(), 'movie_time', true);
                                        $movie_price = get_post_meta(get_the_ID(), 'movie_price', true);
                                        $movie_taken_seats = get_post_meta(get_the_ID(), 'movie_taken_seats', true);
                                        $movie_total_profit = get_post_meta(get_the_ID(), 'movie_total_profit', true);


                                        $parts = explode(":", $movie_duration);
                                        $hours = intval($parts[0]);
                                        $minutes = intval($parts[1]);
                                        $movie_duration_minutes = $hours * 60 + $minutes;

                                        $number_of_taken_seats = 0;
                                        $movie_taken_seats = get_post_meta(get_the_ID(), 'movie_taken_seats', false);
                                        if (isset($movie_taken_seats[0])) {
                                            $number_of_taken_seats = sizeof($movie_taken_seats[0]);
                                        }

                                        if ($movie_total_profit == '') {
                                            $movie_total_profit = 0;
                                        }


                                        // Get the current post type
                                        $post_type = get_post_type();

                                        // Get an array of taxonomy names for the post type
                                        $taxonomies = get_object_taxonomies($post_type, 'names');

                                        // Loop through the taxonomies and get the terms for each one
                                        $filter_movie_date = get_post_meta(get_the_ID(), 'filter_movie_date', true);
                                        //provjera datuma usporava stranicu
                                        $current_time = time();
                                        if ($current_time > strtotime("$filter_movie_date $movie_time") && $flag) {
                                            ?>
                                                <div class="finished-movies-hr">Dovršeni filmovi</div>
                                            <?php
                                            $flag = false;
                                        }
                                            ?>
                                            <div class="movie-statistics-wrapper">
                                           <div class="row justify-content-md-center">
                                                <div class="col-md-auto">
                                                
                                                <img class="img-fluid post-thumb d-none d-md-flex post-thumbnail"
                                                src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="image" style="margin-bottom: 1.5rem;">
                                                </div>
                                        
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 ml-2">
                                                    <h4>Film: </h4>
                                                    <h4>Cijena: </h4>
                                                    <h4>Datum: </h4>
                                                    <h4>Vrijeme: </h4>
                                                    <h4>Sjedala: </h4>
                                                    <h4>Zarada: </h4>

                                                </div>
                                                <div class="col-md-8">
                                                    <h4 style="margin-left:0.75rem;"> <?php the_title(); ?></h4>
                                                    <h4 style="margin-left:0.75rem;"><?php echo $movie_price; ?> &#x20AC</h4>
                                                    <h4 style="margin-left:0.75rem;"><?php echo $movie_date; ?></h4>
                                                    <h4 style="margin-left:0.75rem;"><?php echo $movie_time; ?> </h4>
                                                    <h4 style="margin-left:0.75rem;"><?php echo $number_of_taken_seats; ?> </h4>
                                                    <h4 style="margin-left:0.75rem;"><?php echo $movie_total_profit; ?> &#x20AC</h4>

                                                    <?php
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row justify-content-md-center">
                                                <div class="col-md-auto">
                                                    <button class="btn btn-success btn-large statistics-movie-buttons" data-toggle="modal"
                                                    data-target="#statisticsModal" statistics-movie-title="<?php echo the_title() ?>"
                                                    statistics-movie-price="<?php echo $movie_price ?>" statistics-movie-total-profit="<?php echo $movie_total_profit ?>" 
                                                    statistics-movie-id="<?php echo the_ID() ?>">Pregled sjedala</button>
                                                </div>
                                            </div>
                                            </div>
                                            <?php
                                    endwhile; ?>
                                <?php else: ?>
                                    <div class="container">
                                        <div class="row justify-content-md-center">
                                            <div class="col-md-10">
                                                <div class="movie-wrapper">
                                                    <h1
                                                        style="color: #B88470; display:flex; align-items:center; justify-content: center;">
                                                        Nema
                                                        filmova za prikaz!</h1>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif;
                                wp_reset_postdata();
                                ?>
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="row justify-content-md-center">
                    <div class="col-md-auto border-animation border-animation-start">
                    </div>
                </div>
            </div>
            <div class="col-md-5 statistics-series animated-border-series">
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <h1>Serije</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statisticsModal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="statistics-modal-title-movie-title"></h4>
                <button type="button" class="close statistics-exit-payment" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        Tipovi sjedala:
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                        <p class="seat-type-title">Standardno</p>
                        <div class="seat-regular">*1</div>
                    </div>
                    <div class="col-md-2">
                        <p class="seat-type-title">Ljubavno</p>
                        <div class="seat-love">*2.5</div>
                    </div>
                    <div class="col-md-2">
                        <p class="seat-type-title">Invalidno</p>
                        <div class="seat-disabled">*1</div>
                    </div>
                    <div class="col-md-2">
                        <p class="seat-type-title">VIP</p>
                        <div class="seat-vip">*2</div>
                    </div>
                    <div class="col-md-2">
                        <p class="seat-type-title">Nedostupno</p>
                        <div class="seat-unavailable"></div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <div class="row" style="margin-top: 4rem;">
                    <div class="col-md-6">
                        Prikaz rezervacija
                    </div>
                </div>
                <div class="row justify-content-md-center" style="margin-top: 2rem;">
                    <div class="col-md-auto">
                        <div>
                            <svg width="250" height="50" viewBox="0 0 250 50">
                                <path preserveAspectRatio="xMidYMid meet" d="M 250 0 L 207 32 L 60 31 L 10 0 Z" />
                            </svg>
                        </div>
                        <?php
                        $args_seats = array(
                            'posts_per_page' => -1,
                            'post_type' => 'sjedalo',
                        );
                        $seats_query = new WP_Query($args_seats);
                        $seat_row = '';
                        $array = array();
                        while ($seats_query->have_posts()):
                            $seats_query->the_post();
                            $taxonomies_seat = array('tip_sjedala', 'dostupnost_sjedala', 'red_sjedala');
                            foreach ($taxonomies_seat as $taxonomy_seat) {
                                $terms = wp_get_post_terms(get_the_ID(), $taxonomy_seat);
                                if ($taxonomy_seat == 'red_sjedala') {
                                    foreach ($terms as $term) {
                                        array_push($array, $term->name . get_the_title());
                                    }
                                }
                            }
                        endwhile;


                        //sortiranje sjedala prema redovima i stupcima
                        usort($array, function ($a, $b) {
                            // Extract the first and second characters from each string
                            $char1A = substr($a, 0, 1);
                            $char2A = intval(substr($a, 1, 1));
                            $char1B = substr($b, 0, 1);
                            $char2B = intval(substr($b, 1, 1));

                            // If the first characters are different, sort by first character
                            if ($char1A != $char1B) {
                                return $char1A < $char1B ? -1 : 1;
                            }
                            // If the first characters are the same, sort by second character
                            else {
                                return $char2A < $char2B ? -1 : 1;
                            }
                        });

                        foreach ($array as $arr) {
                            while ($seats_query->have_posts()):
                                $seats_query->the_post();
                                $taxonomies_seat = array('tip_sjedala', 'dostupnost_sjedala', 'red_sjedala');
                                $seat_category = '';
                                $seat_availability = true;
                                foreach ($taxonomies_seat as $taxonomy_seat) {
                                    $terms = wp_get_post_terms(get_the_ID(), $taxonomy_seat);
                                    if ($taxonomy_seat == "tip_sjedala") {
                                        foreach ($terms as $term) {
                                            if ($term->name == "VIP")
                                                $seat_category = "green";
                                            if ($term->name == "Za osobe s invaliditetom")
                                                $seat_category = "purple";
                                            if ($term->name == "Standardno")
                                                $seat_category = "blue";
                                            if ($term->name == "Ljubavno sjedalo")
                                                $seat_category = "red";
                                        }
                                    }
                                    if ($taxonomy_seat == "dostupnost_sjedala") {
                                        foreach ($terms as $term) {
                                            if ($term->name == 'Ne') {
                                                $seat_availability = false;
                                            }
                                        }
                                    }
                                    if ($taxonomy_seat == 'red_sjedala') {
                                        foreach ($terms as $term) {
                                            if ($arr == $term->name . get_the_title()) {
                                                $seat_column = get_the_title();
                                                if ($seat_availability) {
                                                    if ($seat_row == '' || $seat_row == $term->name) {
                                                        echo '<div class="statistics-seat-for-movie" statistics-seat-availability="true" statistics-seat-color=' . $seat_category . ' style="background-color:' . $seat_category . ';">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    } else {
                                                        echo '<br/><div class="statistics-seat-for-movie" statistics-seat-availability="true" statistics-seat-color=' . $seat_category . ' style="background-color: ' . $seat_category . ';">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    }
                                                } else {

                                                    if ($seat_row == '' || $seat_row == $term->name) {
                                                        echo '<div class="statistics-seat-for-movie" statistics-seat-availability="false" statistics-seat-color=' . $seat_category . ' style="background-color:black;">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    } else {
                                                        echo '<br/><div class="statistics-seat-for-movie" statistics-seat-availability="false" statistics-seat-color=' . $seat_category . ' style="background-color:black;">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            endwhile;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <hr class="movie-modal-seperation" />
            <div class="row">
                <div class="col-md-4 offset-md-1">
                    <p class="statistics-movie-price-base"></p>
                </div>
                <div class="col-md-3 offset-md-4">
                    <p>Ukupna zarada: <b class="statistics-movie-profit-total">0&#8364</b></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary statistics-exit-payment" data-dismiss="modal">Zatvori</button>
            </div>
        </div>
    </div>
</div>
</main>
<script>
const moviesDiv = document.querySelector('.statistics-movies');
const seriesDiv = document.querySelector('.statistics-series');
const borderDiv = document.querySelector('.border-animation');
setTimeout(() => {
const height = Math.max(moviesDiv.offsetHeight, seriesDiv.offsetHeight);
borderDiv.style.height = `${height}px`;
    
}, 200);


    var movieButtons = document.querySelectorAll('.statistics-movie-buttons');
    movieButtons.forEach(button => {
        button.addEventListener('click', function () {                
            const overlay = document.querySelector('.overlay');

            console.log('kliknut')
            let movieTitle = this.getAttribute('statistics-movie-title');
            let moviePrice = this.getAttribute('statistics-movie-price');
            let movieTotalProfit = this.getAttribute('statistics-movie-total-profit');
            let moviePriceText = `Osnovna cijena: <b>${moviePrice}&#8364</b>`;
            let movieTotalProfitText = `<b>${movieTotalProfit}&#8364</b>`;

            document.querySelector(".statistics-modal-title-movie-title").innerHTML = movieTitle;
            document.querySelector('.statistics-movie-price-base').innerHTML = moviePriceText;
            document.querySelector('.statistics-movie-profit-total').innerHTML = movieTotalProfitText;

        });
    });

    document.querySelectorAll('.statistics-exit-payment').forEach(exitButton => {
        exitButton.addEventListener('click', function () {
        var seatDivs = document.querySelectorAll('.statistics-seat-for-movie');
        seatDivs.forEach(seatDiv => {
            if (seatDiv.getAttribute('statistics-seat-availability') == 'false') {
                seatDiv.style.backgroundColor = 'black';
                seatDiv.style.color = 'white';
                seatDiv.style.border = 'none';
            } else {
                console.log(seatDiv.getAttribute('statistics-seat-color'))
                seatDiv.style.background = seatDiv.getAttribute('statistics-seat-color');
                seatDiv.style.color = 'white';
                seatDiv.style.border = 'none';
            }
        })
        })
    });

</script>
<?php
get_footer();
?>