<?php get_header(); ?>

<div class="container">
	<div class="row">
		<div class="col-md-8">
			<h1>Kategorie: <?php single_cat_title(); ?></h1>			
			<?php 
				while ( have_posts() ): 
					the_post();
					get_template_part( 'post' );
				endwhile; 
			?>
			
			<?php previous_posts_link();  ?>
			<?php next_posts_link(); ?>
		</div>
		<div class="col-md-4">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>
	</div>
</div>


<?php get_footer(); ?>