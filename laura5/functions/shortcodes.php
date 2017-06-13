<?php 


// [alert type="success"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at nisl dolor. Mauris lacinia dolor quis fermentum lacinia. Sed a pharetra urna.[/alert]

add_shortcode('alert', function( $atts, $content ) {

	$atts = shortcode_atts( array(
		'type' => 'info',
	), $atts , 'alert' );

	ob_start();
	?>
		<div class="alert alert-<?php echo $atts['type'] ?>" role="alert">
			<?php echo $content ?>
		</div>
	<?php 
	return ob_get_clean();
});

// [progress-bar value="40" title="Progress 40%" type="danger"]
add_shortcode('progress-bar', function( $atts, $content ) {
	
	$atts = shortcode_atts( array(
		'value' => '50',
		'title' => '',
		'type' => ''
	), $atts , 'alert' );

	$class = 'progress-bar';
	if ( $atts['type'] ) $class .= ' progress-bar-' . $atts['type'];
	ob_start();

	?>
		<div class="progress">
			<div class="<?php echo $class ?>" role="progressbar" aria-valuenow="<?php echo $atts['value'] ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $atts['value'] ?>%;">
				<?php echo $atts['title'] ?>
			</div>
		</div>
	<?php 

	return ob_get_clean();
});




