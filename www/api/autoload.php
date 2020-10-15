<?php
    // Include config file
    include __DIR__ . '/config/config.php';
        
    // Include composer autoload
    include __DIR__ . '/../../vendor/autoload.php';
    
    // Include ORM
    include __DIR__ . '/src/database.php';
    
    // Include models
    include __DIR__ . '/models/drones.php';
    
    // Include routes
    include __DIR__ . '/routes/index.php';
?>