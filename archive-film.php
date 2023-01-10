<?php
/*
Template Name: Movies Page
*/
get_header();
?>
<div class="overlay">Učitavanje</div>
<main class="main-movies">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-auto">
                <h1 class="movie-welcome-title">FILMOVI</h1>
            </div>
        </div>
        <hr class="hr-movies-title" />
        <div class="movie-filter-section">
            <div class="row">
                <div class="col-md-6" style="margin-bottom: 1rem;">
                    <button class="btn filter-movie-button" type="button" data-toggle="collapse"
                        data-target="#filterMovies" aria-expanded="false" aria-controls="filterMovies">Sortiraj
                        Filmove</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8" style="margin-bottom: 1rem;">
                    <div class="collapse multi-collapse" id="filterMovies">
                        <div class="card card-body" style="background-color: rgb(206, 224, 231, 0.8);">
                            <?php
                            $post_type = get_post_type();

                            $taxonomies = get_object_taxonomies($post_type, 'names');
                            echo '<h3>Pretraživanje</h3>';
                            echo '<input type="text" placeholder="Naziv filma" style="width:50%;" class="movie-search">';
                            echo '<hr/>';
                            foreach ($taxonomies as $taxonomy) {
                                $terms = get_terms(
                                    array(
                                        'taxonomy' => $taxonomy,
                                        'hide_empty' => false,
                                    )
                                );
                                if ($taxonomy == 'žanr') {
                                    echo '<h3>Žanrovi</h3>';
                                    echo '<div class="row">';
                                    foreach ($terms as $term) {
                                        echo '<div class="col-md-3">';
                                        echo '<label><input type="checkbox" name="genre" value="' . $term->name . '"> ' . $term->name . '</label>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '<hr/>';
                                }
                                if ($taxonomy == 'tip_publike') {
                                    echo '<h3 style="margin-top:1rem;">Ciljana grupa</h3>';
                                    echo '<div class="row">';
                                    foreach ($terms as $term) {
                                        echo '<div class="col-md-3">';
                                        echo '<label><input type="checkbox" name="group" value="' . $term->name . '"> ' . $term->name . '</label>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                    echo '<hr/>';
                                }
                                if ($taxonomy == "država") {
                                    echo '<button class="btn btn-large btn-filter-movies filter-movie-button">Filtriraj</button>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            ?>
        </div>
        <?php
        // Query the movies
        $args = array(
            //mjenjano je, mogući error
            'post_type' => 'film',
            'posts_per_page' => -1,
            'meta_key' => 'filter_movie_date',
            'orderby' => 'meta_value',
            'order' => 'ASC'

        );
        $movie_counter = 0;
        $movies_query = new WP_Query($args);
        ?>
        <div class="movies-query-wrapper">
            <?php if ($movies_query->have_posts()): ?>
                <?php while ($movies_query->have_posts()):
                    $movies_query->the_post();
                    $movie_counter++;
                    $movie_date = get_post_meta(get_the_ID(), 'movie_date', true);
                    $movie_time = get_post_meta(get_the_ID(), 'movie_time', true);
                    $movie_duration = get_post_meta(get_the_ID(), 'movie_duration', true);
                    $movie_price = get_post_meta(get_the_ID(), 'movie_price', true);
                    $movie_director = get_post_meta(get_the_ID(), 'movie_director', true);
                    $movie_screenwriter = get_post_meta(get_the_ID(), 'movie_screenwriter', true);
                    $movie_roles = get_post_meta(get_the_ID(), 'movie_roles', true);
                    $movie_taken_seats = get_post_meta(get_the_ID(), 'movie_taken_seats', false);

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
                    $current_time = time();
                    if ($current_time < strtotime("$filter_movie_date $movie_time")) {
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
                                <button class="btn btn-success btn-large movie-btn-reservation" data-toggle="modal"
                                    data-target="#myModal" movie-title="<?php echo $movie_title ?>"
                                    movie-price="<?php echo $movie_price ?>" movie-id="<?php echo the_ID() ?>">Rezerviraj</button>
                            </div>
                        </div>
                        <?php
                    }
                endwhile; ?>
            <?php else: ?>
                <div class="container">
                    <div class="row justify-content-md-center">
                        <div class="col-md-10">
                            <div class="movie-wrapper">
                                <h1 style="color: #B88470; display:flex; align-items:center; justify-content: center;">Nema
                                    filmova za prikaz!</h1>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
</main>
<div>
</div>
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title-movie-title"></h4>
                <button type="button" class="close exit-payment" data-dismiss="modal">&times;</button>
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
                        Odaberite dostupna sjedala:
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
                                                        echo '<div class="seat-for-movie" seat-availability="true" seat-color=' . $seat_category . ' style="background-color:' . $seat_category . ';">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    } else {
                                                        echo '<br/><div class="seat-for-movie" seat-availability="true" seat-color=' . $seat_category . ' style="background-color: ' . $seat_category . ';">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    }
                                                } else {

                                                    if ($seat_row == '' || $seat_row == $term->name) {
                                                        echo '<div class="seat-for-movie" seat-availability="false" seat-color=' . $seat_category . ' style="background-color:black;">' . $term->name . $seat_column . '</div>';
                                                        $seat_row = $term->name;
                                                    } else {
                                                        echo '<br/><div class="seat-for-movie" seat-availability="false" seat-color=' . $seat_category . ' style="background-color:black;">' . $term->name . $seat_column . '</div>';
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
                    <p class="movie-price-base"></p>
                </div>
                <div class="col-md-3 offset-md-4">
                    <p>Ukupna cijena: <b class="movie-price-total">0&#8364</b></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary exit-payment" data-dismiss="modal">Zatvori</button>
                <button type="button" class="btn btn-primary" id="confirm-payment">Potvrdi kupnju</button>
            </div>
        </div>
    </div>
</div>

<script>
    let movieBasePrice = 0;
    var filteredMovieBillSeats = [];
    var filteredMovieBill = 0;
    let updateFilteredMovieBill = document.querySelector('.movie-price-total');

    var filterButtonPressed = false;
    const overlay = document.querySelector('.overlay');
    var seatsResponseRecived = false;

    var movieBill = 0;
    var movieBillSeats = [];
    let updateMovieBill = document.querySelector('.movie-price-total');

    let moviePrice = 0;
    let movieID;
    var movieButtons = document.querySelectorAll('.movie-btn-reservation');
    movieButtons.forEach(button => {
        button.addEventListener('click', function () {
            overlay.style.display = "flex";
            const timerID = setInterval(function () {
                if (seatsResponseRecived) {
                    clearInterval(timerID);
                    overlay.style.display = "none";
                    seatsResponseRecived = false;

                }
            }, 1000);
            console.log('kliknut')
            const movieTitle = this.getAttribute('movie-title');
            moviePrice = this.getAttribute('movie-price');
            movieID = this.getAttribute('movie-id');
            let moviePriceText = `Osnovna cijena: <b>${moviePrice}&#8364</b>`;
            document.querySelector(".modal-title-movie-title").innerHTML = movieTitle;
            document.querySelector('.movie-price-base').innerHTML = moviePriceText;
        });
    });
    var seatDivs = document.querySelectorAll('.seat-for-movie');
    seatDivs.forEach(seatDiv => {
        seatDiv.addEventListener('click', function () {

            document.querySelectorAll('.exit-payment').forEach(exitButton => {
                exitButton.removeAttribute('data-dismiss');
            })

            var seatAvailability = seatDiv.style.backgroundColor;

            if (seatAvailability == "black" || seatAvailability == "rgb(212, 177, 168)") {
                if (seatAvailability == "rgb(212, 177, 168)") {
                    alert("Odabrano sjedalo ste već rezervirali!")
                }
                else {
                    alert("Odabrano sjedalo: " + seatDiv.innerHTML + " je nedostupno.");
                }
            } else {
                var seatAvailability = seatDiv.style.backgroundColor;
            }
            if (seatAvailability == "black" || seatAvailability == "rgb(212, 177, 168)") {
            } else
                if (seatAvailability == "white") {
                    let originalColor = seatDiv.getAttribute('seat-color');
                    seatDiv.style.backgroundColor = originalColor;
                    seatDiv.style.color = 'white';
                    seatDiv.style.border = 'none';
                    movieBill -= moviePrice * seatPrice(seatDiv.getAttribute('seat-color'));
                    updateMovieBill.innerHTML = movieBill + `&#8364`;
                    let index = movieBillSeats.indexOf(seatDiv.innerHTML);
                    if (index > -1) {
                        movieBillSeats.splice(index, 1);
                    }
                } else {
                    console.log('rado')
                    seatDiv.style.backgroundColor = 'white';
                    seatDiv.style.color = 'black';
                    seatDiv.style.border = '1px solid black';
                    movieBill += moviePrice * seatPrice(seatDiv.getAttribute('seat-color'));
                    console.log(moviePrice)
                    movieBillSeats.push(seatDiv.innerHTML)
                    updateMovieBill.innerHTML = movieBill + `&#8364`;
                }
        })
    })


    document.querySelectorAll('.exit-payment').forEach(exitButton => {
        exitButton.addEventListener('click', function () {
            if (movieBillSeats.length != 0) {
                if (confirm("Odabrana sjedala neće Vam ostati zapamćena!")) {
                    document.querySelectorAll('.exit-payment').forEach(exitButton => {
                        exitButton.setAttribute('data-dismiss', 'modal');

                    })
                    movieBill = 0;
                    movieBillSeats = [];
                    updateMovieBill.innerHTML = `0&#8364`;
                    movieBill = 0;
                    movieBillSeats = [];
                    updateMovieBill.innerHTML = `0&#8364`;
                    seatDivs.forEach(seatDiv => {
                        if (seatDiv.getAttribute('seat-availability') == 'false') {
                            seatDiv.style.backgroundColor = 'black';
                            seatDiv.style.color = 'white';
                            seatDiv.style.border = 'none';
                        } else {
                            seatDiv.style.backgroundColor = seatDiv.getAttribute('seat-color');
                            seatDiv.style.color = 'white';
                            seatDiv.style.border = 'none';
                        }
                    })
                }
            }
            else {
                document.querySelectorAll('.exit-payment').forEach(exitButton => {
                    exitButton.setAttribute('data-dismiss', 'modal');
                })

                movieBill = 0;
                movieBillSeats = [];
                updateMovieBill.innerHTML = `0&#8364`;
                seatDivs.forEach(seatDiv => {
                    if (seatDiv.getAttribute('seat-availability') == 'false') {
                        seatDiv.style.backgroundColor = 'black';
                        seatDiv.style.color = 'white';
                        seatDiv.style.border = 'none';
                    } else {
                        seatDiv.style.backgroundColor = seatDiv.getAttribute('seat-color');
                        seatDiv.style.color = 'white';
                        seatDiv.style.border = 'none';
                    }
                })
            }
        })
    });

    function seatPrice(seatCategory) {
        switch (seatCategory) {
            case 'blue':
                return 1
                break;
            case 'red':
                return 2.5
                break;
            case 'purple':
                return 1
                break;
            case 'green':
                return 2
                break;
            default:
                return 1
                break;
        }
    }



</script>

<!-- <script>
    document.querySelector('.btn-filter-movies').addEventListener('click', function () {
        var checkboxes = document.querySelectorAll('input[name="proba"]');
        var values = Array.from(checkboxes).filter(input => input.checked).map(input => input.value);
        var elements = document.querySelector('.movies-query-wrapper');
       elements.innerHTML = '';
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../wp-content/themes/kinopark/movie-query.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status === 200) {
                // success!
                var elements = document.querySelectorAll('.movie-wrapper');
                document.querySelector('.movies-query-wrapper').insertAdjacentHTML('beforeend', xhr.responseText);
                console.log(xhr.responseText)
            }
        };
        xhr.send('selected_taxonomies=' + JSON.stringify(values));
        console.log(values); // Array of values of checked checkboxes
    })
</script> -->

<?php
get_footer();