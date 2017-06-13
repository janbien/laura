<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<?php wp_head(); ?>
</head>
<body>

	<?php 
		while ( have_posts() ):
			the_post();
			?>
				<h2><?php the_title() ?></h2>
				<p>Trvalý odkaz: <a href="<?php the_permalink() ?>"><?php the_permalink() ?></a></p>
				<?php the_content(); ?>
			<?php
		endwhile;
		previous_posts_link(); 
		next_posts_link();
	?>

	<?php wp_footer(); ?>

</body>
</html>