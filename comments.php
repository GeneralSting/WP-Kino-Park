<?php
// pravljenje HTML koda za pisanje komentara-> paragraf za neki tekst, label i textarea za unos komentara te submit button
$comments_args = array(
    // Change the title of send button 
    'label_submit' => __('Pošalji', 'textdomain'),
    // Change the title of the reply section
    'title_reply' => __('Napišite komentar', 'textdomain'),
    // Remove "Text or HTML to be displayed after the set of comment fields".
    'comment_notes_after' => '',
    // Redefine your own textarea (the comment body).
    'comment_field' => '<div style="margin-bottom:8px;" class="comment-form-comment"><label for="comment">' . _x('Komentar*', 'noun') . '</label><br /><textarea id="comment" name="comment" aria-required="true" style="width: 45%"></textarea></div>',
);
?>
<!--div za pregled komentara i unos-->
<div class="comments-wrapper mt-5 comment-section">
    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <!--naslov na sredini diva-->
            <h2 class="comment-reply-title">
                <?php
                if (!have_comments()) {
                    echo "Napiši komentar";
                } else {
                    echo 'Komentara: ' . get_comments_number();
                }
                ?>
            </h2>
        </div>
    </div>
    <hr style="width: 50%;" />
    <!--Pregled napisanih komentara i textarea za napisat komentar-->
    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <!--napisani komentari, ako ih ima-->
            <div>
                <?php
                wp_list_comments(
                    array(
                        'avatar_size' => 50,
                        'style' => 'div'
                    )
                );
                ?>
            </div>
            <hr />
            <!--unos novog komentara-->
            <!--$comments_args na početku definiran (polje)-->
            <div>
                <?php
                if (comments_open())
                    comment_form($comments_args)
                    ?>
            </div>
        </div>
    </div>

</div>