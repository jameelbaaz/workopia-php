<?php

    /**
     * Get the base path
     * 
     * @param string $path
     * @return string
     */
    function basePath($path=''){
        return __DIR__ . '/' .$path;
    }


    /**
     * Load a View
     * 
     * @param string $name 
     * @return void
     */
    function loadView($name){

        $viewPath =basePath("views/{$name}.view.php");
        if(file_exists($viewPath)){
            require  $viewPath;
        }else{
            echo "View {$name} not found";
        }
    }


     /**
     * Load a Partial
     * 
     * @param string $name 
     * @return void
     */
    function loadPartials($name){
        $viewPartials= basePath("views/partials/{$name}.php");
        if(file_exists($viewPartials)){
            require  $viewPartials;
        }else{
            echo "View Parials {$name} not found";
        }
    }

    /**
     * Inspect a values
     * 
     *  @param mixed $value(s)
     *  @return void
     */
    function inspect($value){
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
    }


    /**
     * Inspect a Value(s) and die
     * 
     *  @param mixed $value
     *  @return void
     */
    function inspectAndDie($value){
        echo '<pre>';
        die(var_dump($value));
        echo '</pre>';
    }



