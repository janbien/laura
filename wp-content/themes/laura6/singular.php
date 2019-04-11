<?php get_header(); ?>	

<div class="container">
	<div class="row">
		<div class="col-md-8">	
			<?php while ( have_posts() ): the_post(); ?>
				<h1><?php the_title() ?></h1>
				<?php the_content(); ?>
			<?php endwhile; ?>
			<?php previous_post_link(); ?>
			&nbsp;
			<?php next_post_link(); ?>
		</div>
		<div class="col-md-4">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>