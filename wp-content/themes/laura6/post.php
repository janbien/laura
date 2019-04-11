<?php if ( has_post_format() ) { ?>
	<a href=""><?php the_post_thumbnail( 'my_size' ); ?></a><?php  ?>
<?php } ?>
<h2><?php the_title() ?></h2>
<?php the_tags( '<p>Štítky: ', ' ', '</p>' ); ?>		
<?php the_excerpt(); ?>
<p><a href="<?php the_permalink() ?>">Přečíst</a></p>
