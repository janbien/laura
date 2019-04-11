<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="navbar navbar-default">
	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#laura-header-menu" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</div>

		<div class="collapse navbar-collapse" id="laura-header-menu">
			<?php 
				wp_nav_menu( array(
					'theme_location' => 'top',
					'container' => false,
					'menu_class' => 'nav navbar-nav',
					'fallback_cb' => false
				)); 
			?>
			<div  class="navbar-form navbar-right" >
				<?php get_search_form(); ?>
			</div>		
		</div>
		
	</div>
</header>



