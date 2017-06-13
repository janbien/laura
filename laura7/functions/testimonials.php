<?php 

add_action( 'init', function () {


	register_post_type('testimonial', 
		array(	
			'label' => 'Testimonials',
			'public' => true,
			'supports' => array( 'title', 'revisions', 'editor', 'thumbnail', 'page-attributes' )
		)
	);

	register_taxonomy( 'testimonial_category', array('testimonial'), 
		array(
			'label' => 'Testimonials categories',
			'hierarchical' => true,
			'show_admin_column' => true,			
			'rewrite' => array( 'slug' => 'testimonial/cat' )
		)
	);

});

add_shortcode( 'testimonials', function() {

	$terms = get_terms( 'testimonial_category' );
	ob_start();
	?>	

		<div>

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 1em">
				<?php $i = 0; foreach ( $terms as $term ) { $i++; ?>
					<li role="presentation" <?php if ( $i==1 ) echo 'class="active"'; ?>><a href="#<?php echo $term->slug ?>" aria-controls="<?php echo $term->slug ?>" role="tab" data-toggle="tab"><?php echo $term->name ?></a></li>
				<?php } ?>
			</ul>

			
			<div class="tab-content">


				<?php $i = 0; foreach ( $terms as $term ) { $i++; ?>
					<div role="tabpanel" class="tab-pane <?php if ( $i==1 ) echo 'active'; ?>" id="<?php echo $term->slug ?>">
						<div class="row">
							<?php 
								$query = new WP_Query ( array(
									'post_type' => 'testimonial',
									'posts_per_page' => -1,
									'orderby' => 'menu_order',
									'order' => 'ASC',
									'tax_query' => array(
										array(
											'taxonomy' => 'testimonial_category',
											'field'    => 'id',
											'terms'    => $term->term_id,
										),
									),
								)); 
								$n = 0;
								while ( $query->have_posts() ) {
									$query->the_post();
									$n++;
									?>	
										<div class="col-md-6 col-lg-4">
											<div class="thumbnail">
												<div class="caption">
													<?php the_post_thumbnail( 'testimonial', array( 'class' => 'img-circle') )  ?>
													<h4><?php the_title() ?></h4>
													<?php the_content() ?>
												</div>
											</div>
										</div>
										<?php 
											$cleaner_class = '';
											if ( $n % 2 == 0 ) $cleaner_class .= ' visible-md-block'; 
											if ( $n % 3 == 0 ) $cleaner_class .= ' visible-lg-block'; 
											if ( $cleaner_class ) echo '<div class="clearfix ' . $cleaner_class . '"></div>';
										?>
									<?php
								}
								wp_reset_postdata();
							?>
						</div>
					</div>
				<?php } ?>
			</div>

		</div>


	<?php
	return ob_get_clean();
});


add_action('pre_get_posts', function ($query) {
	if( !is_admin() ) return;
	if ( $query->get('post_type') != 'testimonial' )  return;
	$query->set('orderby', 'menu_order');
	$query->set('order', 'ASC');
});


