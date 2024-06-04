<?php 

    require __DIR__ . '/../vendor/autoload.php';

    require '../helpers.php';

    use Framework\Router;
    
    // require basePath('Framework/Router.php');
    // require basePath('Framework/Database.php');

    // spl_autoload_register(function($class){
    //     $path= basePath('Framework/' .$class .'.php');
    //     if(file_exists($path)){
    //         require $path;
    //     }
    // });

    
    // Instiating the Router
    $router = new Router();

    // Get Routes
    $routes = require basePath('routes.php');

    // Get the Current URI and HTTP METHOD
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


    // Route the request
    $router->route($uri);

    


