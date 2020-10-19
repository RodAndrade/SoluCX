<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    $app = AppFactory::create();
    $middleware = $app->addErrorMiddleware(true,true,true);
    
    // Drones routes
    $app->get('/api/drones', 'Drones::list');
    $app->get('/api/drones/{id}', 'Drones::get');
    $app->post('/api/drones', 'Drones::insert');
    $app->put('/api/drones/{id}', 'Drones::update');
    $app->delete('/api/drones/{id}', 'Drones::delete');
    
    $app->run();
?>