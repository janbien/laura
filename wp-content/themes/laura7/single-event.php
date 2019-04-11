<?php get_header(); ?>	


<div class="container">
	<div class="row">
		<div class="col-md-8">	
			<?php while ( have_posts() ): the_post(); ?>
				<h1><?php the_title() ?></h1>
				<?php if ( get_field( 'date' ) ) { ?>
					<p>Date: <?php the_field( 'date' ); ?></p>
				<?php } ?>
				<?php if ( get_field( 'note' ) ) { ?>
					<p>Note: <?php the_field( 'note' ); ?></p>
				<?php } ?>
				
				<?php the_content(); ?>

			<?php endwhile; ?>

		</div>
		<div class="col-md-4">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>
	</div>
</div>



<?php get_footer(); ?>