<?php 

require_once( __DIR__ . '/vendor/autoload.php');

use Tracy\Debugger;

Debugger::enable( Debugger::DEVELOPMENT, WP_CONTENT_DIR . '/logs/' ); 
Debugger::$email = 'error@example.com';
Debugger::$editor = 'vscode://file/%file:%line';

