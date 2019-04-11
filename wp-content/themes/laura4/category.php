<?php get_header(); ?>

<div class="container">
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

<?php get_footer(); ?>