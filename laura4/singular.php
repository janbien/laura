<?php get_header(); ?>	

<div class="container">

	<?php while ( have_posts() ): the_post(); ?>
		<h1><?php the_title() ?></h1>
		<?php the_content(); ?>
	<?php endwhile; ?>
	<?php previous_post_link(); ?>
	<?php next_post_link(); ?>
	
</div>

<?php get_footer(); ?>