<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div id="header">
		<strong><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php bloginfo( '' ); ?></a></strong>
		<p><?php bloginfo( 'description' ); ?></p>
	</div>

	<hr>

	<?php if ( is_home() ): ?>
		<h1><?php echo get_the_title( get_option('page_for_posts') ) ?></h1>
	<?php elseif ( is_category() ): ?>
		<h1>Kategorie: <?php single_cat_title(); ?></h1>
	<?php elseif ( is_tag() ): ?>
		<h1>Štítek: <?php single_cat_title(); ?></h1>
	<?php elseif ( is_search() ): ?>
		<h1>Hledání: <?php echo  get_search_query(); ?></h1>
	<?php endif; ?>
	
						
	<?php 
		while ( have_posts() ):
			the_post();		
			?>
				<?php if ( is_singular() ): ?>
					<h1><?php the_title() ?></h1>
					<?php the_content(); ?>
					<pre>
						<?php 
							global $post; 
							print_r( $post );
						?>
					</pre>

				<?php else: ?>
					<h2><?php the_title() ?></h2>
					<p>Trvalý odkaz: <a href="<?php the_permalink() ?>"><?php the_permalink() ?></a></p>		
					<?php 
						if ( is_single()) the_content(); 
						else if ( $post->post_excerpt ) the_excerpt();  
					?>

				<?php endif; ?>

			<?php
		endwhile;
		previous_posts_link(); 
		next_posts_link();
	?>

	<?php wp_footer(); ?>

</body>
</html>