<?php get_header(); ?>
<section id="registro">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-7 col-12 pb-4">
                <img src="<?php echo get_template_directory_uri(); ?>/img/kv.png" alt="" class="img-fluid">
            </div>
            <div class="col-lg-5 col-md-5 col-12">
                <?php the_content(); ?>
                <div id="success-message" class="p-3 mb-3 text-bg-success rounded-3">
                    El formulario se ha enviado con éxito!
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>