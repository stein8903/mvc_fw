<?php
namespace Core;

use ReflectionMethod;

class Router
{
    protected $routers;
    
    protected $params;

    /**
     * 
     */
    public function add($route, $param = []): void
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
    public function getRouters(): array
    {
        return $this->routers;
    }

    /**
     * 
     */
    public function match(string $url): bool
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
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * 
     */
    public function dispatch(string $url)
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
                    // $controllerObject->$action();
                    $paramObjects = $this->_getParamObjects($controller, $action);
                    call_user_func_array([$controllerObject, $action], $paramObjects);
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
    private function _convertToStudlyCap(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * 
     */
    private function _convertToCamelCase(string $string): string
    {
        return $this->_convertToStudlyCap(lcfirst($string));
    }

    /**
     * 
     * 
     */
    private function _getParamObjects($class, $method): array
    {
        $paramObjects = [];
        $methodReflection = new ReflectionMethod($class, $method);
        $reflectionParams = $methodReflection->getParameters();
        foreach ($reflectionParams as $param) {
            $paramName = $param->getType()->getName();
            $paramObjects[] = new $paramName();
        }

        return $paramObjects;
    }
}
