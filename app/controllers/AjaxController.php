<?php

class AjaxController
{
    public function __construct() 
    {}

    public function executeRequest()
    {
        try {
            $controller = isset($_GET['c']) ? $_GET['c'] : 'encuesta';
            $action = isset($_GET['a']) ? $_GET['a'] : 'default';

            $controller = ucwords(strtolower($controller)) . 'Controller';
            include_once "./app/controllers/" . $controller . '.php';

            $controller = new $controller();
            $controller->$action();
        } catch (Exception $ex) {
            var_dump("Ocurrio un error al resolver su peticion. Error: " . $ex->getMessage());
        }
    }
}