<?php  

$files = glob( __DIR__ . "/inc/*.php" );
foreach( $files as $file ) if ( file_exists( $file ) ) require_once( $file );

