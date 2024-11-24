<?php get_header(); ?>
<main>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h2 class="fw-light">Retos</h2>
                <p class="lead text-muted">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Molestias esse quas non, aut quasi, veniam reprehenderit iste quibusdam vero optio, dignissimos nesciunt excepturi odit ullam ipsum? Vel totam hic fugit.</p>
            </div>
        </div>
    </section>
    <?php 
    $args = array(
        'post_type'      => 'reto',
        'posts_per_page' => -1,
        'post_status'    => 'publish'
    );
    
    $retos = new WP_Query($args);
    if($retos->posts):
    ?>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php 
                    foreach ($retos->posts as $reto):
                        $retoTitle = $reto->post_title;
                        $retoExcerpt = $reto->post_excerpt;
                        $retoImg = wp_get_attachment_url(get_post_thumbnail_id($reto->ID, 'full'));
                        $retoLink = $reto->guid;
                ?>
                <div class="col">
                    <div class="card shadow-sm">
                        <img src="<?php echo $retoImg; ?>" class="card-img-top" alt="img random">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $retoTitle; ?></h5>
                            <p class="card-text"><?php echo $retoExcerpt; ?></p>
                            <a href="<?php echo $retoLink; ?>" class="btn btn-primary">Ver Reto</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php 
        endif;
    ?>
<?php get_footer(); ?>