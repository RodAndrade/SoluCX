<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    $app = AppFactory::create();
    $middleware = $app->addErrorMiddleware(true,true,true);
    
    // Drones routes
    $app->get('/drones', 'Drones::list');
    $app->get('/drones/{id}', 'Drones::get');
    $app->post('/drones', 'Drones::insert');
    $app->put('/drones/{id}', 'Drones::update');
    $app->delete('/drones/{id}', 'Drones::delete');
    
    $app->run();
?>