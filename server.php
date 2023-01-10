<?php
if (isset($_POST['movie_id'])) {
    $movie_id = $_POST['movie_id'];

    update_post_meta(
        $movie_id,
        'movie_taken_seats',
        array('A5', 'A4')
    );

    $movie_taken_seats = get_post_meta($movie_id, 'movie_taken_seats', false);
    echo $movie_taken_seats;
}
?>