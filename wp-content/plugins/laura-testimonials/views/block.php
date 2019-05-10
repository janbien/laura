<?php 
    $cat = get_field( 'cat' );
    if ( !$cat ) return '<p>No selected category.</p>';
    $query = new WP_Query([
        'post_type' => 'testimonial',
        'posts_per_page' => -1,
        'tax_query' => [
            [
                'taxonomy' => 'testimonial_category',
                'terms'    => $cat,
            ]
        ]
    ]);
?>

<?php 
	while( $query->have_posts() ) { 
        $query->the_post();
        global $post;
        ?>
            <hr>
            <div class="row">
                <div class="col-xs-3 col-sm-2">
                    <?php the_post_thumbnail( 'testimonial', [ 'class' => 'img-circle' ]) ?>
                </div>
                <div class="col-xs-9 col-sm-10">
                    <?php the_content() ?>
                    <p><strong><?php the_title() ?></strong></p>
                </div> 
            </div>
        <?php 
    } 
    wp_reset_postdata();
?>
 <hr>