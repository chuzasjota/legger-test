<?php get_header(); ?>
<?php 
    if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        $retoImg = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID(), 'full'));
?>
<section id="single-reto" class="pt-4">
    <div class="container border-bottom">
        <div class="row g-4 py-5 row-cols-1 row-cols-lg-2">
            <div class="col">
                <h2 class="pb-2"><?php the_title(); ?></h2>
                <a href="<?php echo home_url('registro')?>?rtc=<?php echo get_field('rtc'); ?>" class="btn btn-primary">Registrarme</a>
            </div>
            <div class="col">
                <h2><?php echo get_field('seccion')['titulo_seccion']; ?></h2>
                <p><?php echo get_field('seccion')['descripcion_seccion']; ?></p>
            </div>
        </div>
    </div>
    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="<?php echo $retoImg; ?>" class="d-block mx-lg-auto img-fluid" alt="<?php echo the_title(); ?>" width="700" height="500" loading="lazy">
            </div>
            <div class="col-lg-6">
                <p><?php the_content(); ?></p>
            </div>
        </div>
    </div>
</section>
<?php endwhile; endif; ?>
<?php get_footer(); ?>