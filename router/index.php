<?php

class Router {
    /**
     * Indicates whether the router has been successfully handled.
     */
    private $handled = false;
    
    private $viewsPath;

    function __construct()
    {
        // Set the views path relative to the location of this file
        $this->viewsPath = __DIR__ . '/../views/';
    }

    /**
     * Handle GET routes/requests.
     * 
     * @param string $route The route to handle.
     * @param string $view The view to render.
     */
    public function get($route, $view)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return false;
        }

        $uri = $_SERVER['REQUEST_URI'];
        if ($uri === $route) {
            $this->handled = true;
            include_once $this->viewsPath . $view;
            return;
        }
    }

    /**
     * Handle POST routes/requests.
     * 
     * @param string $route The route to handle.
     * @param string $view The view to render.
     */
    public function post($route, $view)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return false;
        }

        $uri = $_SERVER['REQUEST_URI'];
        if ($uri === $route) {
            include_once $this->viewsPath . $view;
            return;
        }
    }

    /**
     * Handle non-existing routes.
     */
    function __destruct()
    {
        if (!$this->handled) {
            include_once $this->viewsPath . '404.html';
        }
    }
}
