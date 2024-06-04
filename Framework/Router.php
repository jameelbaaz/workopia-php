<?php 

// $routes = require basePath('routes.php');

// if(array_key_exists($uri, $routes)){
//     require(basePath($routes[$uri]));
//  }else{
//     http_response_code(404);
//      require(basePath($routes['404']));
//  }

namespace Framework;

use App\Controllers\ErrorController;


class Router{
    protected $routes=[];


    /**
     * Add a new route
     *
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */
    public function registerRoute($method, $uri, $action){
        // like js destructure
        list($controller, $controllerMethod)=explode('@', $action);        
        $this->routes[] =[
            'method'=>$method,
            'uri'=>$uri,
            'controller'=> $controller,
            'controllerMethod'=> $controllerMethod
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string uri
     * @param string controller
     * @return void
     */
    public function get($uri, $controller){
       $this->registerRoute('GET', $uri, $controller);
    }
    
    
    /**
     * Add a POST route
     * 
     * @param string uri
     * @param string controller
     * @return void
     */
    public function post($uri, $controller){
        $this->registerRoute('POST', $uri, $controller);
    }


    /**
     * Add a PUT route
     * 
     * @param string uri
     * @param string controller
     * @return void
     */
    public function put($uri, $controller){
        $this->registerRoute('PUT', $uri, $controller);
    }


    /**
     * Add a DELETE route
     * 
     * @param string uri
     * @param string controller
     * @return void
     */
    public function delete($uri, $controller){
        $this->registerRoute('DELETE', $uri, $controller);
    }


   


    /**
     * 
     * Route the request
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri){

        $requestMethod=$_SERVER['REQUEST_METHOD'];
        foreach($this->routes as $route){

            // Split the current uri into segments
            $uriSegments = explode("/", trim($uri, '/'));
            
            // Split the route URI into segments
            $routeSegments=explode('/', trim($route['uri'], '/'));

            $match=true;

            // Check if the number of segments matches
            if(count($uriSegments) === count($routeSegments) && strtoupper($route['method']===$requestMethod) ){
                $params=[];
                $match= true;
                for($i=0;$i<count($uriSegments); $i++){
                    // if the uris do not match there no params -- value in curly braces 
                    if($routeSegments[$i]!== $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])){
                            $match=false;
                            break;
                    }

                    // check for the param and add to $paras array
                    if(preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)){
                        $params[$matches[1]]= $uriSegments[$i];
                    }
                }

                if($match){
                    //  Extact controller and controllermethod
                $controller ='App\\Controllers\\' . $route['controller'];
              
                $controllerMethod= $route['controllerMethod'];

                // Instantiate the Class Controller and call the method
                $controllerIntance = new $controller();
                $controllerIntance->$controllerMethod($params);
                return;
                }
            }

            // if($route['uri']===$uri && $route['method']===$method){
            //     // require basePath('App/' .$route['controller']);
            //     // Extact controller and controllermethod
            //     $controller ='App\\Controllers\\' . $route['controller'];
              
            //     $controllerMethod= $route['controllerMethod'];

            //     // Instantiate the Class Controller and call the method
            //     $controllerIntance = new $controller();
            //     $controllerIntance->$controllerMethod();
            //     return;
            // }
        }

        ErrorController::notFound();

       
    }







}