<?php

//Adds dynamic title tag support
function myTheme_support()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    $another_args = array(
        'default-color' => '0000ff',
        'default-image' => get_template_directory_uri() . '/assets/images/background/pozadina_png.jpg',
        'default-repeat' => 'no-repeat',
    );
    add_theme_support('custom-background', $another_args);
}
add_action('after_setup_theme', 'myTheme_support');

function myTheme_register_styles()
{
    $version = wp_get_theme()->get('Version');
    wp_enqueue_style('myTheme-bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css", array(), '4.4.1', 'all');
    wp_enqueue_style('myTheme-fontawesome', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css", array(), '5.13.0', 'all');
    wp_enqueue_style('myTheme-style', get_template_directory_uri() . "./style.css", array('myTheme-bootstrap'), $version, 'all');

}

function myTheme_register_scripts()
{
    $version = wp_get_theme()->get('Version');
    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js');
    wp_enqueue_script('jquery');
    wp_enqueue_script('myTheme-popper', "https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js", array(), "1.16.0", true);
    wp_enqueue_script('myTheme-bootstrap', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js", array(), "3.4.1", true);
    wp_enqueue_script('myTheme-main', get_template_directory_uri() . "/assets/js/main.js", array('jquery'), $version, true);

}
add_action('wp_enqueue_scripts', 'myTheme_register_styles');
add_action('wp_enqueue_scripts', 'myTheme_register_scripts');



function enqueue_datepicker_scripts()
{
    // Load the jQuery UI datepicker script
    wp_enqueue_script('jquery-ui-datepicker');

    // Load the jQuery UI datepicker styles
    wp_enqueue_style('jquery-ui-datepicker-css', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', false, '1.12.1', 'all');

    // Load the jQuery UI Timepicker Addon script
    wp_enqueue_script('jquery-ui-timepicker', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js', array('jquery-ui-datepicker'), '1.6.3', true);

    // Load the jQuery UI Timepicker Addon styles
    wp_enqueue_style('jquery-ui-timepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css', false, '1.6.3', 'all');
}
add_action('admin_enqueue_scripts', 'enqueue_datepicker_scripts');

function myTheme_menus()
{
    $locations = array(
        'primary' => __('Primary Menu', 'THEMENAME'),
        'secondary' => __('Secondary Menu', 'SecondaryMenu'),
        'primary-admin' => __('Primary Admin Menu', 'PrimaryAdminMenu')
    );
    register_nav_menus($locations);
}
add_action('init', 'myTheme_menus');

function my_theme_posts_link_attributes()
{
    return 'class="btn btn-primary"';
}
add_filter('next_posts_link_attributes', 'my_theme_posts_link_attributes');

/**
 * Register Custom Navigation Walker
 */
function register_navwalker()
{
    if (!file_exists(get_template_directory() . '/class-wp-bootstrap-navwalker.php')) {
        // File does not exist... return an error.
        return new WP_Error('class-wp-bootstrap-navwalker-missing', __('It appears the class-wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
    } else {
        // File exists... require it.
        require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
    }
}
add_action('after_setup_theme', 'register_navwalker');


# Dodavanje logotipa
function theme_custom_logo()
{
    if (function_exists("the_custom_logo")) {
        the_custom_logo();
    }
}

function make_main_nav_items()
{
    return '<ul id="%1$s" class="navbar-nav me-auto mb-0 mb-ml-5 %2$s">%3$s</ul>';
}

/*      CPT Film     */

function register_cpt_film()
{
    $labels = array(
        'name' => _x('Filmovi', 'Post Type General Name', 'vuv'),
        'singular_name' => _x('Film', 'Post Type Singular Name', 'vuv'),
        'menu_name' => __('Filmovi', 'vuv'),
        'name_admin_bar' => __('Filmovi', 'vuv'),
        'archives' => __('Filmovi arhiva', 'vuv'),
        'attributes' => __('Atributi', 'vuv'),
        'parent_item_colon' => __('Roditeljski element', 'vuv'),
        'all_items' => __('Svi filmovi', 'vuv'),
        'add_new_item' => __('Dodaj novi film', 'vuv'),
        'add_new' => __('Dodaj novi film', 'vuv'),
        'new_item' => __('Novi film', 'vuv'),
        'edit_item' => __('Uredi film', 'vuv'),
        'update_item' => __('Ažuriraj film', 'vuv'),
        'view_item' => __('Pogledaj film', 'vuv'),
        'view_items' => __('Pogledaj filmove', 'vuv'),
        'search_items' => __('Pretraži filmove', 'vuv'),
        'not_found' => __('Nije pronađeno', 'vuv'),
        'not_found_in_trash' => __('Nije pronađeno u smeću', 'vuv'),
        'featured_image' => __('Glavna slika', 'vuv'),
        'set_featured_image' => __('Postavi glavnu sliku', 'vuv'),
        'remove_featured_image' => __('Ukloni glavnu sliku', 'vuv'),
        'use_featured_image' => __('Postavi za glavnu sliku', 'vuv'),
        'insert_into_item' => __('Umentni', 'vuv'),
        'uploaded_to_this_item' => __('Preneseno', 'vuv'),
        'items_list' => __('Lista', 'vuv'),
        'items_list_navigation' => __('Navigacija među filmovima', 'vuv'),
        //moguci problem
        'filter_items_list' => __('Filtriranje filmova', 'vuv'),
    );
    $args = array(
        'label' => __('Film', 'vuv'),
        'description' => __('Film post type', 'vuv'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => false,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('film', $args);
}
add_action('init', 'register_cpt_film', 0);

function register_taxonomy_zanr()
{
    $labels = array(
        'name' => _x(
            'Žanrovi',
            'Taxonomy General Name',
            'vuv'
        ),
        'singular_name' => _x(
            'Žanr',
            'Taxonomy Singular Name',
            'vuv'
        ),
        'menu_name' => __('Žanr', 'vuv'),
        'all_items' => __('Svi Žanrovi', 'vuv'),
        'parent_item' => __('Roditeljski žanr', 'vuv'),
        'parent_item_colon' => __('Roditeljski žanr', 'vuv'),
        'new_item_name' => __('Novi žanr', 'vuv'),
        'add_new_item' => __('Dodaj novi žanr', 'vuv'),
        'edit_item' => __('Uredi žanr', 'vuv'),
        'update_item' => __('Ažuiriraj žanr', 'vuv'),
        'view_item' => __('Pogledaj žanr', 'vuv'),
        'separate_items_with_commas' => __('Odvojite žanrove sa zarezima', 'vuv'),
        'add_or_remove_items' => __('Dodaj ili ukloni žanr', 'vuv'),
        'choose_from_most_used' => __('Odaberi među najčešće korištenima', 'vuv'),
        'popular_items' => __('Popularni žanrovi', 'vuv'),
        'search_items' => __('Pretraga', 'vuv'),
        'not_found' => __('Nema rezultata', 'vuv'),
        'no_terms' => __('Nema žanrova', 'vuv'),
        'items_list' => __('Lista žanrova', 'vuv'),
        'items_list_navigation' => __('Navigacija', 'vuv'), //moguci problem
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('žanr', array('film'), $args);
}
add_action('init', 'register_taxonomy_zanr', 0);

function register_taxonomy_tip_publike()
{
    $labels = array(
        'name' => _x(
            'Tip publike',
            'Taxonomy General Name',
            'vuv'
        ),
        'singular_name' => _x(
            'Tip publike',
            'Taxonomy Singular Name',
            'vuv'
        ),
        'menu_name' => __('Namjenjenoj publici', 'vuv'),
        'all_items' => __('Svi tipovi publika', 'vuv'),
        'parent_item' => __('Roditelj tipa publike', 'vuv'),
        'parent_item_colon' => __('Roditeljski tip publika', 'vuv'),
        'new_item_name' => __('Novi tip publike', 'vuv'),
        'add_new_item' => __('Dodaj novi tip publike', 'vuv'),
        'edit_item' => __('Uredi tip publike', 'vuv'),
        'update_item' => __('Ažuiriraj tip publike', 'vuv'),
        'view_item' => __('Pogledaj tip publike', 'vuv'),
        'separate_items_with_commas' => __('Odvojite tipove publika sa zarezima', 'vuv'),
        'add_or_remove_items' => __('Dodaj ili ukloni tip publike', 'vuv'),
        'choose_from_most_used' => __('Odaberi među najčešće korištenima', 'vuv'),
        'popular_items' => __('Popularni tipovi publika', 'vuv'),
        'search_items' => __('Pretraga', 'vuv'),
        'not_found' => __('Nema rezultata', 'vuv'),
        'no_terms' => __('Nema tipova publike', 'vuv'),
        'items_list' => __('Lista tipova publike', 'vuv'),
        'items_list_navigation' => __('Navigacija', 'vuv'), //moguci problem
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('tip_publike', array('film'), $args);
}
add_action('init', 'register_taxonomy_tip_publike', 0);

function register_taxonomy_drzava()
{
    $labels = array(
        'name' => _x(
            'Države',
            'Taxonomy General Name',
            'vuv'
        ),
        'singular_name' => _x(
            'Država',
            'Taxonomy Singular Name',
            'vuv'
        ),
        'menu_name' => __('Države', 'vuv'),
        'all_items' => __('Sve države', 'vuv'),
        'parent_item' => __('Roditelj državi', 'vuv'),
        'parent_item_colon' => __('Roditeljska država', 'vuv'),
        'new_item_name' => __('Nova država', 'vuv'),
        'add_new_item' => __('Dodaj novu državu', 'vuv'),
        'edit_item' => __('Uredi državu', 'vuv'),
        'update_item' => __('Ažuiriraj državu', 'vuv'),
        'view_item' => __('Pogledaj državu', 'vuv'),
        'separate_items_with_commas' => __('Odvojite države sa zarezima', 'vuv'),
        'add_or_remove_items' => __('Dodaj ili ukloni državu', 'vuv'),
        'choose_from_most_used' => __('Odaberi među najčešće korištenima', 'vuv'),
        'popular_items' => __('Popularne države', 'vuv'),
        'search_items' => __('Pretraga', 'vuv'),
        'not_found' => __('Nema rezultata', 'vuv'),
        'no_terms' => __('Nema država', 'vuv'),
        'items_list' => __('Lista država', 'vuv'),
        'items_list_navigation' => __('Navigacija', 'vuv'), //moguci problem
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    register_taxonomy('država', array('film'), $args);
}
add_action('init', 'register_taxonomy_drzava', 0);

/*      Dohvaćanje filmova za prikaz        */

function get_filmove($slug)
{
    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'film',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'žanr',
                'field' => 'slug',
                'terms' => $slug
            )
        )
    );
    $nastavnici = get_posts($args);
    $sHtml = "<ul>";
    foreach ($nastavnici as $nastavnik) {
        $sNastavnikUrl = $nastavnik->guid;
        $sNastavnikNaziv = $nastavnik->post_title;
        $sHtml .= '<li><a href="' . $sNastavnikUrl . '">' . $sNastavnikNaziv . '</a></li>';
    }
    $sHtml .= "</ul>";
    return $sHtml;
}

/*      FILMOVI->CMB    */
/*      Obavezna polja  */

//klasično dodavanje 4 obevezna cmb-a
function add_meta_box_movie_details()
{
    add_meta_box('meta_boxes_film', 'Obavezno', 'html_meta_box_film', 'film');
}
function html_meta_box_film($post)
{
    wp_nonce_field('save_html_meta_box_film', 'movie_date_nonce');
    wp_nonce_field('save_html_meta_box_film', 'movie_time_nonce');
    wp_nonce_field('save_html_meta_box_film', 'movie_duration_nonce');
    wp_nonce_field('save_html_meta_box_film', 'movie_price_nonce');
    wp_nonce_field('save_html_meta_box_film', 'filter_movie_date_nonce');
    //dohvaćanje meta vrijednosti
    $movie_date = get_post_meta($post->ID, 'movie_date', true);
    $movie_time = get_post_meta($post->ID, 'movie_time', true);
    $movie_duration = get_post_meta($post->ID, 'movie_duration', true);
    $movie_price = get_post_meta($post->ID, 'movie_price', true);
    $filter_movie_date = get_post_meta($post->ID, 'filter_movie_date', true);
    echo '
<div>
    <div>
        <label for="movie_date">Datum i vrijeme: </label>
        <input type="text" id="movie-time-picker" name="movie_time" data-toggle="tooltip"
        title="Vrijeme se broji od ulaska na web-stranicu" placeholder="Vrijeme"
        value="' . $movie_time . '" style="float:right; margin-right:30%;" autocomplete="off" />
        <input type="text" id="movie-date-picker" name="movie_date" placeholder="Datum"
        value="' . $movie_date . '" style="float:right; margin-right:10px;" autocomplete="off" />
        </div><br/>
    <div>
        <label for="movie-duration">Trajanje: </label>
        <input type="time" id="movie-duration" name="movie_duration"
        value="' . $movie_duration . '" style="float:right; margin-right:58.3%;" autocomplete="off" />
    </div><br/>
        <div>
        <label for="movie_price">Cijena: </label>
        <div style="display:inline; float:right; margin-right:47.8%">
            <input type="number" id="movie-price" onkeypress="return (event.charCode >= 48 || event.charCode == 46)" min="0"
            name="movie_price" value="' . $movie_price . '" autocomplete="off" />
            &euro;
        </div>
    </div></br>
    <hr/ style="height: 0px; border: none; border-top: 2px solid black; width: 80%; margin-top: 10px; margin-bottom: 20px;">
    <div>
        <label for="filter-movie-date">Filter datuma:</label>
        <input type="text" id="filter-movie-date" name="filter_movie_date" placeholder="GGGG-MM-DD"
        value="' . $filter_movie_date . '" style="float:right; margin-right:49%;" autocomplete="off" />
    </div><br/>
</div>';
    ?>

    <!--postavljanje datepicker i timepicker -->
    <script>
        jQuery(function ($) {
            //movie-date-picker
            var dateToday = new Date();
            var selectedToday = false;
            //provjera da li je danas prošlo 18:00h
            var referenceTime = new Date();
            referenceTime.setHours(18);
            referenceTime.setMinutes(0);
            referenceTime.setSeconds(0);
            if (dateToday > referenceTime) {
                var dateTomorrow = new Date();
                dateTomorrow.setDate(dateToday.getDate() + 1);
                $("#movie-date-picker").datepicker({
                    minDate: dateTomorrow,
                    regional: ["hr"],
                    onSelect: function (dateText, selectedDate) {
                        $.timepicker.setDefaults($.timepicker.regional['hr'] = {
                            timeText: "Vrijeme",
                            hourText: 'Sati',
                            minuteText: 'Minute',
                            currentText: 'Sada',
                            closeText: 'Zatvori'
                        });
                        $("#movie-time-picker").timepicker({
                            onSelect: function (time) {
                                document.querySelector('#publish').disabled = true;
                            }
                        })
                    }
                })
            } else {
                // Initialize the datepicker
                $("#movie-date-picker").datepicker({
                    minDate: dateToday,
                    regional: ["hr"],
                    onSelect: function (dateText, selectedDate) {
                        $("#movie-time-picker").timepicker('destroy');
                        document.querySelector('#movie-time-picker').value = null;
                        document.querySelector('#publish').disabled = true;
                        if (selectedDate.currentDay == dateToday.getDate()) {
                            var currentTime = new Date();
                            //mora biti minimalno 6 sati od trenutnog vremena                    
                            var minTime = new Date(currentTime.getTime() + 6 * 60 * 60 * 1000);
                            var minTimeString = minTime.getHours() + ':' + minTime.getMinutes();
                            $.timepicker.setDefaults($.timepicker.regional['hr'] = {
                                timeText: "Vrijeme(+6 sati od otvaranja web-stranice!)",
                                hourText: 'Sati',
                                minuteText: 'Minute',
                                currentText: 'Sada + 6',
                                closeText: 'Zatvori'
                            });
                            $("#movie-time-picker").timepicker({
                                showButtonPanel: false,
                                minTime: minTimeString,
                                maxTime: '23:59',
                                onSelect: function (time) {
                                    document.querySelector('#publish').disabled = true;
                                }
                            })
                        } else {
                            $.timepicker.setDefaults($.timepicker.regional['hr'] = {
                                timeText: "Vrijeme",
                                hourText: 'Sati',
                                minuteText: 'Minute',
                                currentText: 'Sada',
                                closeText: 'Zatvori'
                            });
                            $("#movie-time-picker").timepicker({
                                onSelect: function (time) {
                                    document.querySelector('#publish').disabled = true;
                                }
                            })
                        }
                    }
                })
            }
        });
    </script>
    <?php
}

function film_drzava_convert_radio_buttons($args)
{
    if (!empty($args['taxonomy']) && $args['taxonomy'] === 'država' /* <== Change to your required taxonomy */) {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) { // Don't override 3rd party walkers.
            if (!class_exists('WPSE_139269_Walker_Category_Radio_Checklist')) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist
                {
                    function walk($elements, $max_depth, ...$args)
                    {
                        $output = parent::walk($elements, $max_depth, ...$args);
                        $output = str_replace(
                            array('type="checkbox"', "type='checkbox'"),
                            array('type="radio"', "type='radio'"),
                            $output
                        );

                        return $output;
                    }
                }
            }
            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }
    return $args;
}
add_filter('wp_terms_checklist_args', 'film_drzava_convert_radio_buttons');

//kod za spremanje cmb-a na klik objavi
function save_html_meta_box_film($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce_movie_date = (isset($_POST['movie_date_nonce']) && wp_verify_nonce(
        $_POST['movie_date_nonce'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_movie_time = (isset($_POST['movie_time_nonce']) && wp_verify_nonce(
        $_POST['movie_time_nonce'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_movie_duration = (isset($_POST['movie_duration_nonce']) && wp_verify_nonce(
        $_POST['movie_duration_nonce'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_movie_price = (isset($_POST['movie_price_nonce']) && wp_verify_nonce(
        $_POST['movie_price_nonce'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_filter_movie_date = (isset($_POST['filter_movie_date']) && wp_verify_nonce(
        $_POST['filter_movie_date_nonce'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    if (
        $is_autosave || $is_revision || !$is_valid_nonce_movie_date ||
        !$is_valid_nonce_movie_time || !$is_valid_nonce_movie_duration ||
        !$is_valid_nonce_movie_price || !$is_valid_nonce_filter_movie_date
    ) {
        return;
    }
    if (!empty($_POST['movie_date'])) {
        update_post_meta(
            $post_id,
            'movie_date',
            $_POST['movie_date']
        );
    }
    if (!empty($_POST['movie_time'])) {
        update_post_meta(
            $post_id,
            'movie_time',
            $_POST['movie_time']
        );
    }
    if (!empty($_POST['movie_duration'])) {
        update_post_meta(
            $post_id,
            'movie_duration',
            $_POST['movie_duration']
        );
    }
    if (!empty($_POST['movie_price'])) {
        update_post_meta(
            $post_id,
            'movie_price',
            $_POST['movie_price']
        );
    }
    if (!empty($_POST['filter_movie_date'])) {
        update_post_meta(
            $post_id,
            'filter_movie_date',
            $_POST['filter_movie_date']
        );
    }
}
add_action('add_meta_boxes', 'add_meta_box_movie_details');
add_action('save_post', 'save_html_meta_box_film');


//onemogućavanje spremi dugme bez provjere unesenih podataka
function disable_new_custom_post_type_button()
{
    // Check if we are on the custom post type screen
    global $current_screen;
    if ($current_screen->post_type == 'film') {
        ?>
        <script>
            // Select the button and disable it
            document.querySelector('#publish').disabled = true;
            var checkBtn = document.createElement("input");
            checkBtn.type = "button";
            checkBtn.value = "Provjera";
            checkBtn.className = "button button-primary button-large"
            checkBtn.onclick = function () {
                clearInputListeners();
                var genreTaxonomy = false;
                var publicTaxonomy = false;
                var genreTaxonomyElement = document.querySelector('#žanrchecklist');
                for (let item of genreTaxonomyElement.children) {
                    if (item.children[0].children[0].checked == true) {
                        genreTaxonomy = true;
                    }
                }
                var publicTaxonomyElement = document.querySelector('#tip_publikechecklist');
                for (let item of publicTaxonomyElement.children) {
                    if (item.children[0].children[0].checked == true) {
                        publicTaxonomy = true;
                    }
                }
                if (genreTaxonomy && publicTaxonomy) {
                    if (((document.getElementById("movie-date-picker").value) === "") ||
                        ((document.getElementById("movie-time-picker").value) === "") ||
                        ((document.getElementById("movie-duration").value) === "") ||
                        ((document.getElementById("movie-price").value) === "") ||
                        ((document.getElementById("filter-movie-date").value) === "")) {
                        alert("Popunite sva obavezna polja");
                    }
                    else {
                        document.querySelector('#publish').disabled = false;
                        followInputChanges();
                    }
                }
                else
                    alert("Odaberite vrijednosti za Žanrove i Tip publike")
            };

            var btnSpace = document.getElementById("delete-action");
            btnSpace.appendChild(checkBtn);
            //brisanje akcije "premjesti u smeće" kako nam ne bi ometalo provjera button koji smo ručno dodali
            var deleteActionElement = document.querySelector('.submitdelete');
            deleteActionElement.remove();

            //funkcija za praćenje klika na obavezne inpute radi provjere 
            function followInputChanges() {
                var inputMovieTime = document.getElementById("movie-time-picker");
                var inputMovieDuration = document.getElementById("movie-duration");
                var inputMoviePrice = document.getElementById("movie-price");

                inputMovieTime.addEventListener("click", function () {
                    document.querySelector('#publish').disabled = true;
                });
                inputMovieDuration.addEventListener("click", function () {
                    document.querySelector('#publish').disabled = true;
                });
                inputMoviePrice.addEventListener("click", function () {
                    document.querySelector('#publish').disabled = true;
                });
            }

            //funkcija za poništavanje praćenja obaveznih inputa
            function clearInputListeners() {
                var inputMovieTime = document.getElementById("movie-time-picker");
                var inputMovieDuration = document.getElementById("movie-duration");
                var inputMoviePrice = document.getElementById("movie-price");

                inputMovieTime.removeEventListener("click", null);
                inputMovieDuration.removeEventListener("click", null);
                inputMoviePrice.removeEventListener("click", null);
            }

        </script>
        <?php
    }
}
add_action('admin_footer', 'disable_new_custom_post_type_button');

/*      Dodatna polja   */

function add_meta_box_movie_details_optional()
{
    add_meta_box('optional_meta_boxes_film', 'Dodatno', 'html_meta_box_optional_film', 'film');
}
function html_meta_box_optional_film($post)
{
    wp_nonce_field('save_html_meta_box_optional_film', 'movie_trailer');
    wp_nonce_field('save_html_meta_box_optional_film', 'movie_director');
    wp_nonce_field('save_html_meta_box_optional_film', 'movie_screenwriter');
    wp_nonce_field('save_html_meta_box_optional_film', 'movie_roles');
    wp_nonce_field('save_html_meta_box_optional_film', 'movie_taken_seats');
    wp_nonce_field('save_html_meta_box_optional_film', 'movie_total_profit');

    //dohvaćanje meta vrijednosti
    $movie_trailer = get_post_meta($post->ID, 'movie_trailer', true);
    $movie_director = get_post_meta($post->ID, 'movie_director', true);
    $movie_screenwriter = get_post_meta($post->ID, 'movie_screenwriter', true);
    $movie_roles = get_post_meta($post->ID, 'movie_roles', true);
    $movie_taken_seats = get_post_meta($post->ID, 'movie_taken_seats', true);
    $movie_total_profit = get_post_meta($post->ID, 'movie_total_profit', true);


    echo '
    <div>
        <div>
            <label for="movie_trailer">Triler URL: </label>
            <input type="text" id="movie-trailer" name="movie_trailer" placeholder="https://youtube/triler.com"
            value="' . $movie_trailer . '" style="float:right; margin-right:37%; width: 30%" autocomplete="off" />
        </div><br/>
        <div>
        <label for="movie_director">Redatelj: </label>
            <input type="text" id="movie-director" name="movie_director" value="' . $movie_director . '"
            style="float:right; margin-right:37%; width: 30%" placeholder="Ime redatelja" autocomplete="off"/>
        </div></br>
        <div>
        <label for="movie_screenwriter">Scenarist: </label>
            <input type="text" id="movie-screenwriter" name="movie_screenwriter" value="' . $movie_screenwriter . '"
            style="float:right; margin-right:37%; width: 30%" placeholder="Ime scenarista" autocomplete="off"/>
        </div></br>
        <div>
            <label for="movie_roles">Uloge: </label>
            <input type="text" id="movie-roles" name="movie_roles" value="' . $movie_roles . '"
            style="float:right; margin-right:37%; width: 30%" placeholder="Uloge odvojiti zarezom" autocomplete="off"/>
        </div></br>
        <input type="hidden" name="movie_taken_seats" value="' . $movie_taken_seats . '"/>
        <input type="hidden" name="movie_total_profit" value="' . $movie_total_profit . '"/>
    </div>';
}

function save_html_meta_box_optional_film($post_id)
{
    $is_autosave = wp_is_post_autosave($post_id);
    $is_revision = wp_is_post_revision($post_id);
    $is_valid_nonce_movie_trailer = (isset($_POST['movie_trailer']) && wp_verify_nonce(
        $_POST['movie_trailer'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_movie_director = (isset($_POST['movie_director']) && wp_verify_nonce(
        $_POST['movie_director'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_movie_screenwriter = (isset($_POST['movie_screenwriter']) && wp_verify_nonce(
        $_POST['movie_screenwriter'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    $is_valid_nonce_movie_roles = (isset($_POST['movie_roles']) && wp_verify_nonce(
        $_POST['movie_roles'],
        basename(__FILE__)
    )
    ) ? 'true' : 'false';
    if (
        $is_autosave || $is_revision || !$is_valid_nonce_movie_trailer || !$is_valid_nonce_movie_director ||
        !$is_valid_nonce_movie_screenwriter || !$is_valid_nonce_movie_roles
    ) {
        return;
    }
    if (!empty($_POST['movie_trailer'])) {
        update_post_meta(
            $post_id,
            'movie_trailer',
            $_POST['movie_trailer']
        );
    }
    if (!empty($_POST['movie_director'])) {
        update_post_meta(
            $post_id,
            'movie_director',
            $_POST['movie_director']
        );
    }
    if (!empty($_POST['movie_screenwriter'])) {
        update_post_meta(
            $post_id,
            'movie_screenwriter',
            $_POST['movie_screenwriter']
        );
    }
    if (!empty($_POST['movie_roles'])) {
        update_post_meta(
            $post_id,
            'movie_roles',
            $_POST['movie_roles']
        );
    }
}
add_action('add_meta_boxes', 'add_meta_box_movie_details_optional');
add_action('save_post', 'save_html_meta_box_optional_film');


/*      CPT Sjedište        */

function register_cpt_sjedalo()
{
    $labels = array(
        'name' => _x('Sjedala', 'Post Type General Name', 'vuv'),
        'singular_name' => _x('Sjedalo', 'Post Type Singular Name', 'vuv'),
        'menu_name' => __('Sjedala', 'vuv'),
        'name_admin_bar' => __('Sjedala', 'vuv'),
        'archives' => __('Sjedala arhiva', 'vuv'),
        'attributes' => __('Atributi', 'vuv'),
        'parent_item_colon' => __('Roditeljski element', 'vuv'),
        'all_items' => __('Sva sjedala', 'vuv'),
        'add_new_item' => __('Dodaj novi film', 'vuv'),
        'add_new' => __('Dodaj novo sjedalo', 'vuv'),
        'new_item' => __('Nova sjedalo', 'vuv'),
        'edit_item' => __('Uredi sjedalo', 'vuv'),
        'update_item' => __('Ažuriraj sjedalo', 'vuv'),
        'view_item' => __('Pogledaj sjedalo', 'vuv'),
        'view_items' => __('Pogledaj sjedalo', 'vuv'),
        'search_items' => __('Pretraži sjedala', 'vuv'),
        'not_found' => __('Nije pronađeno', 'vuv'),
        'not_found_in_trash' => __('Nije pronađeno u smeću', 'vuv'),
        'featured_image' => __('Glavna slika', 'vuv'),
        'set_featured_image' => __('Postavi glavnu sliku', 'vuv'),
        'remove_featured_image' => __('Ukloni glavnu sliku', 'vuv'),
        'use_featured_image' => __('Postavi za glavnu sliku', 'vuv'),
        'insert_into_item' => __('Umentni', 'vuv'),
        'uploaded_to_this_item' => __('Preneseno', 'vuv'),
        'items_list' => __('Lista', 'vuv'),
        'items_list_navigation' => __('Navigacija među sjedalima', 'vuv'),
        //moguci problem
        'filter_items_list' => __('Filtriranje sjedala', 'vuv'),
    );
    $args = array(
        'label' => __('Sjedalo', 'vuv'),
        'description' => __('Sjedalo post type', 'vuv'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-groups',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => false,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
    );
    register_post_type('sjedalo', $args);
}
add_action('init', 'register_cpt_sjedalo', 0);

/*  Taksonomija Tip sjedala     */
function register_taxonomy_tip_sjedala()
{
    $labels = array(
        'name' => _x(
            'Tip sjedala',
            'Taxonomy General Name',
            'vuv'
        ),
        'singular_name' => _x(
            'Tip sjedala',
            'Taxonomy Singular Name',
            'vuv'
        ),
        'menu_name' => __('Tip sjedala', 'vuv'),
        'all_items' => __('Svi tipovi sjedala', 'vuv'),
        'parent_item' => __('Roditeljski žanr', 'vuv'),
        'parent_item_colon' => __('Roditeljski tip sjedala', 'vuv'),
        'new_item_name' => __('Novi tip sjedala', 'vuv'),
        'add_new_item' => __('Dodaj novi tip sjedala', 'vuv'),
        'edit_item' => __('Uredi tip sjedala', 'vuv'),
        'update_item' => __('Ažuiriraj tip sjedala', 'vuv'),
        'view_item' => __('Pogledaj tip sjedala', 'vuv'),
        'separate_items_with_commas' => __('Odvojite tipove sjedala sa zarezima', 'vuv'),
        'add_or_remove_items' => __('Dodaj ili ukloni tip sjedala', 'vuv'),
        'choose_from_most_used' => __('Odaberi među najčešće korištenima', 'vuv'),
        'popular_items' => __('Popularni tipovi sjedala', 'vuv'),
        'search_items' => __('Pretraga', 'vuv'),
        'not_found' => __('Nema rezultata', 'vuv'),
        'no_terms' => __('Nema tipova sjedala', 'vuv'),
        'items_list' => __('Lista tipova sjedala', 'vuv'),
        'items_list_navigation' => __('Navigacija', 'vuv'), //moguci problem
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,

    );
    register_taxonomy('tip_sjedala', array('sjedalo'), $args);
}
add_action('init', 'register_taxonomy_tip_sjedala', 0);

/*  Taksonomija Red sjedala     */
function register_taxonomy_red_sjedala()
{
    $labels = array(
        'name' => _x(
            'Red sjedala',
            'Taxonomy General Name',
            'vuv'
        ),
        'singular_name' => _x(
            'Red sjedala',
            'Taxonomy Singular Name',
            'vuv'
        ),
        'menu_name' => __('Red sjedala', 'vuv'),
        'all_items' => __('Svi redovi sjedala', 'vuv'),
        'parent_item' => __('Roditeljski red sjedala', 'vuv'),
        'parent_item_colon' => __('Roditeljski red sjedala', 'vuv'),
        'new_item_name' => __('Novi red sjedala', 'vuv'),
        'add_new_item' => __('Dodaj novi red sjedala', 'vuv'),
        'edit_item' => __('Uredi red sjedala', 'vuv'),
        'update_item' => __('Ažuiriraj red sjedala', 'vuv'),
        'view_item' => __('Pogledaj red sjedala', 'vuv'),
        'separate_items_with_commas' => __('Odvojite redove sjedala sa zarezima', 'vuv'),
        'add_or_remove_items' => __('Dodaj ili ukloni red sjedala', 'vuv'),
        'choose_from_most_used' => __('Odaberi među najčešće korištenima', 'vuv'),
        'popular_items' => __('Popularni redovi sjedala', 'vuv'),
        'search_items' => __('Pretraga', 'vuv'),
        'not_found' => __('Nema rezultata', 'vuv'),
        'no_terms' => __('Nema redova sjedala', 'vuv'),
        'items_list' => __('Lista redova sjedala', 'vuv'),
        'items_list_navigation' => __('Navigacija', 'vuv'), //moguci problem
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,

    );
    register_taxonomy('red_sjedala', array('sjedalo'), $args);
}
add_action('init', 'register_taxonomy_red_sjedala', 0);


/*  Taksonomija Dostupnost sjedala      */
function register_taxonomy_dostupnost_sjedala()
{
    $labels = array(
        'name' => _x(
            'Dostpunost sjedala',
            'Taxonomy General Name',
            'vuv'
        ),
        'singular_name' => _x(
            'Dostpunost sjedala',
            'Taxonomy Singular Name',
            'vuv'
        ),
        'menu_name' => __('Dostpunost sjedala', 'vuv'),
        'all_items' => __('Sva dostupna sjedala', 'vuv'),
        'parent_item' => __('Roditeljski dostupna sjedala', 'vuv'),
        'parent_item_colon' => __('Roditeljski dostupna sjedala', 'vuv'),
        'new_item_name' => __('Nova dostupnost sjedala', 'vuv'),
        'add_new_item' => __('Dodaj novu dostupnost sjedala', 'vuv'),
        'edit_item' => __('Uredi dostupnost sjedala', 'vuv'),
        'update_item' => __('Ažuiriraj dostupnost sjedala', 'vuv'),
        'view_item' => __('Pogledaj dostupnost sjedala', 'vuv'),
        'separate_items_with_commas' => __('Odvojite dostupnosti sjedala sa zarezima', 'vuv'),
        'add_or_remove_items' => __('Dodaj ili ukloni dostupnost sjedala', 'vuv'),
        'choose_from_most_used' => __('Odaberi među najčešće korištenima', 'vuv'),
        'popular_items' => __('Popularne dostupnosti sjedala', 'vuv'),
        'search_items' => __('Pretraga', 'vuv'),
        'not_found' => __('Nema rezultata', 'vuv'),
        'no_terms' => __('Nema dostupnosti sjedala', 'vuv'),
        'items_list' => __('Lista dostupnosti sjedala', 'vuv'),
        'items_list_navigation' => __('Navigacija', 'vuv'), //moguci problem
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,

    );
    register_taxonomy('dostupnost_sjedala', array('sjedalo'), $args);
}
add_action('init', 'register_taxonomy_dostupnost_sjedala', 0);




/*
 * Use radio inputs instead of checkboxes for term checklists in sjedalo taxonomies.
 *
 * @param   array   $args
 * @return  array
 * 
 */
function tip_sjedala_convert_radio_buttons($args)
{
    if (!empty($args['taxonomy']) && $args['taxonomy'] === 'tip_sjedala' /* <== Change to your required taxonomy */) {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) { // Don't override 3rd party walkers.
            if (!class_exists('WPSE_139269_Walker_Category_Radio_Checklist')) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist
                {
                    function walk($elements, $max_depth, ...$args)
                    {
                        $output = parent::walk($elements, $max_depth, ...$args);
                        $output = str_replace(
                            array('type="checkbox"', "type='checkbox'"),
                            array('type="radio"', "type='radio'"),
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }
    return $args;
}
add_filter('wp_terms_checklist_args', 'tip_sjedala_convert_radio_buttons');

function red_sjedala_convert_radio_buttons($args)
{
    if (!empty($args['taxonomy']) && $args['taxonomy'] === 'red_sjedala' /* <== Change to your required taxonomy */) {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) { // Don't override 3rd party walkers.
            if (!class_exists('WPSE_139269_Walker_Category_Radio_Checklist')) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist
                {
                    function walk($elements, $max_depth, ...$args)
                    {
                        $output = parent::walk($elements, $max_depth, ...$args);
                        $output = str_replace(
                            array('type="checkbox"', "type='checkbox'"),
                            array('type="radio"', "type='radio'"),
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }
    return $args;
}
add_filter('wp_terms_checklist_args', 'red_sjedala_convert_radio_buttons');


function dostupnost_sjedala_convert_radio_buttons($args)
{
    if (!empty($args['taxonomy']) && $args['taxonomy'] === 'dostupnost_sjedala' /* <== Change to your required taxonomy */) {
        if (empty($args['walker']) || is_a($args['walker'], 'Walker')) { // Don't override 3rd party walkers.
            if (!class_exists('WPSE_139269_Walker_Category_Radio_Checklist')) {
                /**
                 * Custom walker for switching checkbox inputs to radio.
                 *
                 * @see Walker_Category_Checklist
                 */
                class WPSE_139269_Walker_Category_Radio_Checklist extends Walker_Category_Checklist
                {
                    function walk($elements, $max_depth, ...$args)
                    {
                        $output = parent::walk($elements, $max_depth, ...$args);
                        $output = str_replace(
                            array('type="checkbox"', "type='checkbox'"),
                            array('type="radio"', "type='radio'"),
                            $output
                        );

                        return $output;
                    }
                }
            }

            $args['walker'] = new WPSE_139269_Walker_Category_Radio_Checklist;
        }
    }
    return $args;
}
add_filter('wp_terms_checklist_args', 'dostupnost_sjedala_convert_radio_buttons');



function check_new_sjedalo()
{
    // Check if we are on the custom post type screen
    global $current_screen;
    if ($current_screen->post_type == 'sjedalo') {
        ?>
        <script>
            document.querySelector('#publish').disabled = true;
            var seatTypeSelected = false;
            var seatRowSelected = false;
            var seatAvailabilitySelected = false;
            var checkBtn = document.createElement("input");
            checkBtn.type = "button";
            checkBtn.value = "Provjera";
            checkBtn.className = "button button-primary button-large"
            checkBtn.onclick = function () {
                var seatTypeElement = document.querySelector("#dostupnost_sjedalachecklist")
                for (let item of seatTypeElement.children) {
                    if (item.children[0].children[0].checked == true) {
                        seatTypeSelected = true;
                    }
                }

                var seatRowElement = document.querySelector("#red_sjedalachecklist")
                for (let item of seatRowElement.children) {
                    if (item.children[0].children[0].checked == true) {
                        seatRowSelected = true;
                    }
                }

                var seatAvailabilityElement = document.querySelector("#tip_sjedalachecklist")
                for (let item of seatAvailabilityElement.children) {
                    if (item.children[0].children[0].checked == true) {
                        seatAvailabilitySelected = true;
                    }
                }

                if (seatTypeSelected && seatRowSelected && seatAvailabilitySelected)
                    document.querySelector('#publish').disabled = false;
                else
                    alert("Odaberite vrijednosti svih taksonomija")
            };
            var btnSpace = document.getElementById("delete-action");
            btnSpace.appendChild(checkBtn);
            //brisanje akcije "premjesti u smeće" kako nam ne bi ometalo provjera button koji smo ručno dodali
            var deleteActionElement = document.querySelector('.submitdelete');
            deleteActionElement.remove();
        </script>
        <?php
    }
}
add_action('admin_footer', 'check_new_sjedalo');











function myplugin_ajaxurl()
{
    echo '<script type="text/javascript">
    var ajaxurl = "' . admin_url('admin-ajax.php') . '";
    </script>';
}
add_action('wp_head', 'myplugin_ajaxurl');

//The Javascript

function ajax_get_taken_seats()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var movieButtons = document.querySelectorAll('.movie-btn-reservation');
            movieButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (filterButtonPressed) {
                        $.ajax({
                            url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                            data: {
                                'action': 'php_ajax_get_taken_seats', // This is our PHP function below
                                'movie_id': filteredMovieID
                            },
                            type: 'post',
                            success: function (result) {
                                var array = result.split(',');
                                array.forEach(element => {
                                    seatDivs.forEach(seatDiv => {
                                        if (seatDiv.innerHTML == element) {
                                            seatDiv.style.backgroundColor = "black";
                                            seatDiv.style.color = "white";

                                        }
                                    });
                                });
                                seatsResponseRecived = true;
                            },
                            error: function (error) {
                                console.warn(error);
                            }
                        })
                    }
                    else {
                        $.ajax({
                            url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                            data: {
                                'action': 'php_ajax_get_taken_seats', // This is our PHP function below
                                'movie_id': movieID
                            },
                            type: 'post',
                            success: function (result) {
                                var array = result.split(',');
                                array.forEach(element => {
                                    seatDivs.forEach(seatDiv => {
                                        if (seatDiv.innerHTML == element) {
                                            seatDiv.style.backgroundColor = "black";
                                            seatDiv.style.color = "white";

                                        }
                                    });
                                });
                                seatsResponseRecived = true;
                            },
                            error: function (error) {
                                console.warn(error);
                            }
                        })
                    }

                })
            })


        })
    </script>
    <?php
}
add_action('wp_footer', 'ajax_get_taken_seats');

function php_ajax_get_taken_seats()
{

    if (isset($_POST['movie_id'])) {
        $movie_id = $_POST['movie_id'];
        $movie_taken_seats = get_post_meta($movie_id, 'movie_taken_seats', true);
        foreach ($movie_taken_seats as $taken) {
            if ($taken == end($movie_taken_seats)) {
                echo $taken;
            } else {
                echo $taken . ',';
            }
        }
    }
    die();
}

add_action('wp_ajax_php_ajax_get_taken_seats', 'php_ajax_get_taken_seats');
add_action('wp_ajax_nopriv_php_ajax_get_taken_seats', 'php_ajax_get_taken_seats');


function ajax_get_statistics_taken_seats()
{
    ?>
    <script>
        jQuery(document).ready(function ($) {
            var movieButtons = document.querySelectorAll('.statistics-movie-buttons');
            movieButtons.forEach(button => {
                button.addEventListener('click', function () {
                    let movieID = this.getAttribute('statistics-movie-id');
                    $.ajax({
                        url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                        data: {
                            'action': 'php_ajax_get_statistics_taken_seats', // This is our PHP function below
                            'movie_id': movieID
                        },
                        type: 'post',
                        success: function (result) {
                            console.log(result)
                            var recivedReservationSeats = result.split(',');
                            recivedReservationSeats.forEach(reservedSeat => {
                                var seatDivs = document.querySelectorAll('.statistics-seat-for-movie');
                                seatDivs.forEach(seatDiv => {
                                    if (seatDiv.innerHTML == reservedSeat) {
                                        var seatColor = seatDiv.getAttribute('statistics-seat-color');
                                        seatDiv.style.background = `linear-gradient(to right, ${seatColor} 50%, black 50%)`;
                                        seatDiv.style.color = "white";
                                    }
                                });
                            });
                        },
                        error: function (error) {
                            console.warn(error);
                        }
                    })
                })
            })


        })
    </script>
    <?php
}
add_action('wp_footer', 'ajax_get_statistics_taken_seats');

function php_ajax_get_statistics_taken_seats()
{

    if (isset($_POST['movie_id'])) {
        $movie_id = $_POST['movie_id'];
        $movie_taken_seats = get_post_meta($movie_id, 'movie_taken_seats', true);
        foreach ($movie_taken_seats as $taken) {
            if ($taken == end($movie_taken_seats)) {
                echo $taken;
            } else {
                echo $taken . ',';
            }
        }
    }
    die();
}

add_action('wp_ajax_php_ajax_get_statistics_taken_seats', 'php_ajax_get_statistics_taken_seats');
add_action('wp_ajax_nopriv_php_ajax_get_statistics_taken_seats', 'php_ajax_get_statistics_taken_seats');

function ajax_confirmed_payment()
{
    ?>
    <script>
        var purchasedMovieSeats = [];
        jQuery(document).ready(function ($) {
            $(document).on('click', '#confirm-payment', function () {
                if (filterButtonPressed) {
                    if (movieBillSeats.length > 0) {
                        overlay.style.display = "flex";
                        const timerID = setInterval(function () {
                            if (seatsResponseRecived) {
                                clearInterval(timerID);
                                overlay.style.display = "none";
                                seatsResponseRecived = false;
                            }
                        }, 1000);
                        console.log(movieBillSeats);
                        $.ajax({
                            url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                            data: {
                                'action': 'php_ajax_confirmed_payment', // This is our PHP function below
                                'movie_id': filteredMovieID,
                                'taken_seats': movieBillSeats,
                                'movie_bill': movieBill
                            },
                            type: 'post',
                            success: function (result) {
                                console.log(result)
                                document.querySelectorAll('.exit-payment').forEach(exitButton => {
                                    exitButton.setAttribute('data-dismiss', 'modal');
                                })
                                purchasedMovieSeats = movieBillSeats;
                                var seatDivs = document.querySelectorAll('.seat-for-movie');
                                purchasedMovieSeats.forEach(purchasedMovieSeat => {
                                    seatDivs.forEach(seatDiv => {
                                        if (seatDiv.innerHTML == purchasedMovieSeat) {
                                            seatDiv.style.backgroundColor = 'rgb(212, 177, 168)';
                                        }
                                    })
                                });
                                let paymentAlertMessage = movieBillSeats.join(", ");
                                alert('Uspješno ste rezervirali ' + paymentAlertMessage + ' sjedala');
                                movieBillSeats = [];
                                filteredMovieBill = 0;
                                updateFilteredMovieBill.innerHTML = filteredMovieBill

                                movieBill = 0;
                                updateMovieBill.innerHTML = movieBill;

                                seatsResponseRecived = true;
                            },
                            error: function (error) {
                                console.warn(error);
                            }
                        })
                    }
                    else {
                        alert("Niste odabrali sjedalo za rezervaciju!");
                    }
                }
                else {
                    if (movieBillSeats.length > 0) {
                        overlay.style.display = "flex";
                        const timerID = setInterval(function () {
                            if (seatsResponseRecived) {
                                clearInterval(timerID);
                                overlay.style.display = "none";
                                seatsResponseRecived = false;

                            }
                        }, 1000);
                        $.ajax({
                            url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                            data: {
                                'action': 'php_ajax_confirmed_payment', // This is our PHP function below
                                'movie_id': movieID,
                                'taken_seats': movieBillSeats,
                                'movie_bill': movieBill
                            },
                            type: 'post',
                            success: function (result) {
                                console.log(result)
                                document.querySelectorAll('.exit-payment').forEach(exitButton => {
                                    exitButton.setAttribute('data-dismiss', 'modal');
                                })
                                purchasedMovieSeats = movieBillSeats;
                                var seatDivs = document.querySelectorAll('.seat-for-movie');
                                purchasedMovieSeats.forEach(purchasedMovieSeat => {
                                    seatDivs.forEach(seatDiv => {
                                        if (seatDiv.innerHTML == purchasedMovieSeat) {
                                            seatDiv.style.backgroundColor = 'rgb(212, 177, 168)';
                                        }
                                    })
                                });
                                let paymentAlertMessage = movieBillSeats.join(", ");
                                alert('Uspješno ste rezervirali ' + paymentAlertMessage + ' sjedala');
                                movieBillSeats = [];
                                filteredMovieBill = 0;
                                updateFilteredMovieBill.innerHTML = filteredMovieBill

                                movieBill = 0;
                                updateMovieBill.innerHTML = movieBill;

                                seatsResponseRecived = true;
                            },
                            error: function (error) {
                                console.warn(error);
                            }
                        })
                    }
                    else {
                        alert("Niste odabrali sjedalo za rezervaciju!");
                    }
                }
            })
        })
    </script>
    <?php
}
add_action('wp_footer', 'ajax_confirmed_payment');

function php_ajax_confirmed_payment()
{
    if (isset($_POST['taken_seats']) && isset($_POST['movie_id']) && isset($_POST['movie_bill'])) {
        $taken_seats = $_POST['taken_seats'];
        $movie_id = $_POST['movie_id'];
        $movie_bill = $_POST['movie_bill'];
        if (empty(get_post_meta($movie_id, 'movie_total_profit', true))) {
            update_post_meta($movie_id, 'movie_total_profit', $movie_bill);
        } else {
            $movie_current_profit = get_post_meta($movie_id, 'movie_total_profit', true);
            update_post_meta($movie_id, 'movie_total_profit', $movie_bill + $movie_current_profit);
        }
        if (empty(get_post_meta($movie_id, 'movie_taken_seats', true))) {
            update_post_meta($movie_id, 'movie_taken_seats', $taken_seats);
            print_r($taken_seats);
        } else {
            $merged_array = array_merge(get_post_meta($_POST['movie_id'], 'movie_taken_seats', true), $taken_seats);
            update_post_meta($movie_id, 'movie_taken_seats', $merged_array);
            print_r($merged_array);
        }
    }
    die();
}

add_action('wp_ajax_php_ajax_confirmed_payment', 'php_ajax_confirmed_payment');
add_action('wp_ajax_nopriv_php_ajax_confirmed_payment', 'php_ajax_confirmed_payment');

function add_this_script_footer()
{ ?>
    <script>
        let filteredMovieID;


        jQuery(document).ready(function ($) {

            $(document).on('click', '.btn-filter-movies', function () {
                filterButtonPressed = true;
                overlay.style.display = "flex";
                const timerID = setInterval(function () {
                    if (seatsResponseRecived) {
                        clearInterval(timerID);
                        overlay.style.display = "none";
                        seatsResponseRecived = false;

                    }
                }, 1000);

                var movieSearch = document.querySelector('.movie-search').value;

                var genreCheckboxes = document.querySelectorAll('input[name="genre"]:checked');
                var genreChecked = Array.from(genreCheckboxes).map(function (genreCheckbox) {
                    return genreCheckbox.value;
                });
                var groupCheckboxes = document.querySelectorAll('input[name="group"]:checked');
                var groupChecked = Array.from(groupCheckboxes).map(function (groupCheckbox) {
                    return groupCheckbox.value;
                });


                $.ajax({
                    url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                    data: {
                        'action': 'example_ajax_request', // This is our PHP function below
                        'search': movieSearch,
                        'genre': genreChecked, // This is the variable we are sending via AJAX
                        'group': groupChecked // This is the variable we are sending via AJAX

                    },
                    type: 'post',
                    success: function (result) {
                        console.log('napravljen')

                        document.querySelector('.movies-query-wrapper').innerHTML = '';
                        document.querySelector('.movies-query-wrapper').innerHTML = result;


                        let moviePriceSecond;
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

                                const movieTitle = this.getAttribute('movie-title');
                                moviePriceSecond = this.getAttribute('movie-price');
                                moviePrice = moviePriceSecond;
                                movieBasePrice = moviePriceSecond;
                                filteredMovieID = this.getAttribute('movie-id');
                                moviePriceSecond = `Osnovna cijena: <b>${moviePriceSecond}&#8364</b>`;
                                document.querySelector(".modal-title-movie-title").innerHTML = movieTitle;
                                document.querySelector('.movie-price-base').innerHTML = moviePriceSecond;
                                $.ajax({
                                    url: ajaxurl, // Since WP 2.8 ajaxurl is always defined and points to admin-ajax.php
                                    data: {
                                        'action': 'php_ajax_get_taken_seats', // This is our PHP function below
                                        'movie_id': filteredMovieID
                                    },
                                    type: 'post',
                                    success: function (result) {
                                        var array = result.split(',');

                                        array.forEach(element => {
                                            seatDivs.forEach(seatDiv => {
                                                if (seatDiv.innerHTML == element) {
                                                    seatDiv.style.backgroundColor = "black";
                                                }
                                            });
                                        });
                                        seatsResponseRecived = true;
                                    },
                                    error: function (error) {
                                        console.warn(error);
                                    }
                                })
                            })
                        })




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


                        document.querySelectorAll('.exit-payment').forEach(exitButton => {
                            if (purchasedMovieSeats != []) {
                                var seatDivs = document.querySelectorAll('.seat-for-movie');
                                purchasedMovieSeats.forEach(purchasedMovieSeat => {
                                    seatDivs.forEach(seatDiv => {
                                        if (seatDiv.innerHTML == purchasedMovieSeat) {
                                            seatDiv.style.backgroundColor = seatDiv.getAttribute('seat-color')
                                        }
                                    })
                                });
                            }
                            exitButton.addEventListener('click', function () {
                                filteredMovieBill = 0;
                            })
                        });

                        seatsResponseRecived = true;
                    },
                    error: function (error) {
                        console.warn(error);
                    }
                })
            });
        });
    </script>
<?php }
add_action('wp_footer', 'add_this_script_footer');

//The PHP
function example_ajax_request()
{
    // Koristit se OR relacije izmedu tax_query
    // Query the movies
    $args = array(
        //mjenjano je, mogući error
        'post_type' => 'film',
        'posts_per_page' => -1,
        'meta_key' => 'filter_movie_date',
        'orderby' => 'meta_value',
        'order' => 'ASC'

    );
    if (isset($_POST['search']) && !empty($_POST['search'])) {
        $movie_search = $_POST['search'];
        $args['s'] = $movie_search;
    }
    if (isset($_POST['genre']) && !empty($_POST['genre']) && isset($_POST['group']) && !empty($_POST['group'])) {
        $movie_genre = $_POST['genre'];
        $movie_group = $_POST['group'];

        $args['tax_query'] = array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'žanr',
                'field' => 'name',
                'terms' => $movie_genre,
            ),
            array(
                'taxonomy' => 'tip_publike',
                'field' => 'name',
                'terms' => $movie_group,
            ),
        );
    } else
        if (isset($_POST['genre']) && !empty($_POST['genre'])) {
            $movie_genre = $_POST['genre'];
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'žanr',
                    'field' => 'name',
                    'terms' => $movie_genre,
                )
            );
        } else
            if (isset($_POST['group']) && !empty($_POST['group'])) {
                $movie_group = $_POST['group'];
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'tip_publike',
                        'field' => 'name',
                        'terms' => $movie_group,
                    )
                );
            }
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
                            <button class="btn btn-success btn-large movie-btn-reservation" movie-id="<?php echo the_ID() ?>"
                                data-toggle="modal" data-target="#myModal" movie-price="<?php echo $movie_price ?>"
                                movie-title="<?php echo $movie_title ?>">Rezerviraj</button>
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
                            <h1 style="color: #B88470; display:flex; align-items:center; justify-content: center;">Nema filmova
                                za prikaz!</h1>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
        wp_reset_postdata();
        ?>
    </div>
    <?php

    die();
}
// This bit is a special action hook that works with the WordPress AJAX functionality.
add_action('wp_ajax_example_ajax_request', 'example_ajax_request');
add_action('wp_ajax_nopriv_example_ajax_request', 'example_ajax_request');


/*
// function create_product_post_type()
// {
//     register_post_type(
//         'product',
//         array(
//             'labels' => array(
//                 'name' => __('Products'),
//                 'singular_name' => __('Product')
//             ),
//             'public' => true,
//             'has_archive' => true,
//             'rewrite' => array('slug' => 'products'),
//             'supports' => array('title', 'editor', 'thumbnail', 'custom-fields')
//         )
//     );
// }
// add_action('init', 'create_product_post_type');
// function add_to_cart()
// {
//     if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
//         $product_id = intval($_POST['product_id']);
//         $quantity = intval($_POST['quantity']);
//         $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
//         if (isset($cart[$product_id])) {
//             $cart[$product_id] += $quantity;
//         } else {
//             $cart[$product_id] = $quantity;
//         }
//         $_SESSION['cart'] = $cart;
//     }
// }
// add_action('init', 'add_to_cart');
// function display_cart()
// {
//     $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
//     if (!empty($cart)) {
//         echo '<table style="color:white;">';
//         echo '<tr><th>Product</th><th>Quantity</th><th>Total</th></tr>';
//         $total = 0;
//         foreach ($cart as $product_id => $quantity) {
//             $product = get_post($product_id);
//             $price = get_post_meta($product_id, 'price', true);
//             // Make sure the price is numeric before calculating the total
//             if (is_numeric($price)) {
//                 $product_total = $price * $quantity;
//                 $total += $product_total;
//             }
//             echo '<tr>';
//             echo '<td>' . $product->post_title . '</td>';
//             echo '<td>' . $quantity . '</td>';
//             // Only display the total if the price is numeric
//             if (is_numeric($price)) {
//                 echo '<td>' . $product_total . '</td>';
//             } else {
//                 echo '<td>N/A</td>';
//             }
//             echo '</tr>';
//         }
//         echo '<tr><td colspan="2">Total:</td><td>' . $total . '</td></tr>';
//         echo '</table>';
//     } else {
//         echo '<p>Your cart is empty</p>';
//     }
// }