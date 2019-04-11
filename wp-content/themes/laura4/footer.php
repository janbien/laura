<?php wp_footer(); ?>

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

</body>
</html>