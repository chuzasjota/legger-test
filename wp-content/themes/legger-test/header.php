<!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">
        <?php wp_head(); ?>
    </head>
    <body>
    <?php wp_body_open(); ?>
        <header>
            <nav class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container">
                    <h1>
                        <a href="<?php echo home_url(); ?>" class="navbar-brand d-flex align-items-center">
                            <strong><?php echo esc_html( get_bloginfo( 'name' ) ) ?></strong>
                        </a>
                    </h1>
                    <?php 
                        if(is_home()){
                            echo do_shortcode('[export_button]');
                        }
                    ?>
                </div>
            </nav>
        </header>
