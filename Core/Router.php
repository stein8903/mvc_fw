<?php

namespace Core;

class Router
{
    protected $routers;
    
    protected $params;

    /**
     * 
     */
    public function add($route, $param = [])
    {
        $route = preg_replace('/\//', '\/', $route);
        
        $route = preg_replace('/\{([a-z-]+)\}/', '(?P<\1>[a-z-]+)', $route);

        $route = preg_replace('/\{([a-z-]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        $route = '/^' . $route . '$/i';

        $this->routers[$route] = $param;
    }

    /**
     * 
     */
    public function getRouters()
    {
        return $this->routers;
    }

    /**
     * 
     */
    public function match($url)
    {
        foreach ($this->routers as $router => $param) {
            if (preg_match($router, $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $param[$key] = $value;
                    }
                }
                $this->params = $param;
                return true;
            }
        }

        return false;
    }
    
    /**
     * 
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * 
     */
    public function dispatch($url)
    {
        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->_convertToStudlyCap($controller);
            $controller = 'App\Controllers\\' . $controller;
            if (class_exists($controller)) {
                $action = $this->params['action'];
                $action = $this->_convertToCamelCase($this->params['action']);
                $controllerObject = new $controller();
                if (is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    echo "action name {$action} doesn't exists";
                }
            } else {
                echo "controller named {$controller} doesnt exists";
            }
        } else {
            echo "no route matches";
        }
    }

    /**
     * 
     */
    private function _convertToStudlyCap($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * 
     */
    private function _convertToCamelCase($string)
    {
        return $this->_convertToStudlyCap(lcfirst($string));
    }
}
