<?php 

	$columns = 0;
	for ( $i = 1; $i < 5; $i++ ) {
		if ( is_active_sidebar( "footer-{$i}" ) ) $columns++;
	}
	if ( $columns ) {
		$span = 12 / $columns;
		$class = "col-md-{$span}";
		if ( $columns == 4 ) $class .= " col-sm-6";
		?>
			<hr>
			<div class="container">
				<div class="row">
					<?php 
						for ( $i = 1; $i < 5; $i++ ) { 
							if ( is_active_sidebar( "footer-{$i}" ) ) {
								?>

									<div class="<?php echo $class ?>">
										<?php  dynamic_sidebar( "footer-{$i}" );?>
									</div>
									<?php if ( $i == 2 and $columns == 4 ) { ?>
										<div class="clearfix visible-sm-block"></div>
									<?php } ?>
								<?php 
							}
						}
					?>
				</div>
			</div>
		<?php
	}
?>

<hr>

<div class="container">
	<p>
		<?php 
			$copyright = 'Copyright &copy; 2017 Jan Bien.';
			$copyright = apply_filters ( 'laura_copyright', $copyright );
			echo $copyright;
		?>
	</p>
</div>

<?php wp_footer(); ?>

</body>
</html>