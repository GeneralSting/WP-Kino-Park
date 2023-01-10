<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog Site Template">
    <meta name="author" content="https://github.com/GeneralSting">
    <link rel="shortcut icon" href="./wp-content/themes/kinoPark/assets/images/logo.png">
    <?php
    //Kako bi se pokrenio kod unutar datoteke functions.php potrebno je prije zatvaranja <head>
    //elementa pozvati WordPress funkciju wp_head()
    //*wp_footer()* 
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <header id="main-header">
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" id="main-home-navigation">
            <!--dohvacanje loga -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="container" id="full-main-navigation">
                    <div class="row justify-content-md-center" id="navigation-row">
                        <div class="col-md-5 d-flex align-items-end">
                            <?php
                            wp_nav_menu(
                                array(
                                    'theme_location' => 'secondary',
                                    'depth' => 2,
                                    'container' => 'div',
                                    'container_class' => 'secondary-navigation-items',
                                    'menu_class' => '',
                                    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                    'items_wrap' => make_main_nav_items(),
                                    'walker' => new WP_Bootstrap_Navwalker(),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-md-2 d-flex justify-content-center" id="navigation-bridge">
                            <?php theme_custom_logo(); ?>
                        </div>
                        <div class="col-md-5">
                            <?php
                            //glavni navigacijski izbornik, bootstrap i Navwalker
                            if (user_can(wp_get_current_user(), 'administrator')) {
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',  //primary-admin
                                        'depth' => 2,                   //1
                                        'container' => 'div',
                                        'container_class' => 'main-navigation-items',
                                        'menu_class' => '',
                                        'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                        'items_wrap' => make_main_nav_items(),
                                        'walker' => new WP_Bootstrap_Navwalker(),
                                    )
                                );
                            } else {
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'primary',
                                        'depth' => 1,
                                        'container' => 'div',
                                        'container_class' => 'main-navigation-items',
                                        'menu_class' => '',
                                        'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                        'items_wrap' => make_main_nav_items(),
                                        'walker' => new WP_Bootstrap_Navwalker(),
                                    )
                                );
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <!--prikaz loga i teksta naziva stranice-->
    </header>