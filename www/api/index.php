<?php
    if(file_exists( __DIR__ . '/config/config.php' )){
        include __DIR__.'/autoload.php';
        
        date_default_timezone_set(TIMEZONE);
    } else {
		die(json_encode([
			'error' => 'Por favor, confira o seu arquivo config.php'
		]));
    }
    
    
?>