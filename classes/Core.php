<?php

namespace classes;

use classes\Request;
use models\Users;

class Core
{
    public string $action;
    public string $controller;
    private static $instance = null;
    protected Template $mainTtemplate;
    public $db = null;
    public $session = null;
    public function __construct()
    {
        $this->mainTtemplate = new Template('layout/light/index.php');
        $host = Config::getInstance()->host;
        $dbname = Config::getInstance()->dbname;
        $user = Config::getInstance()->user;
        $password = Config::getInstance()->password;
        $this->db = new DB($host, $user, $password, $dbname);
        $this->session = new Session();
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function Init()
    {
        session_start();
    }

    public function run()
    {
        $route = $_GET['route'] ?? '';
        $parts = explode('/', trim($route, '/'));
        if (Users::isAdminLogin()) {
            $this->setLayout('layout/admin/index.php');
        }
        if (strlen($parts[0]) == 0) {
            $parts[0] = 'Site';
            $parts[1] = 'main';
        }
        if (count($parts) < 2) {
            $parts[1] = 'index';
        }
        $this->controller = $parts[0];
        $this->action = $parts[1];
        $controllerName = "controllers\\" . ucfirst($this->controller) . 'Controller';
        $actionName = "action" . ucfirst($this->action);
        if (!class_exists($controllerName)) {
            return $this->error(404);
        }

        $controllerObject = new $controllerName;

        if (!method_exists($controllerObject, $actionName)) {
            return $this->error(404);
        }

        $method = Request::method();
        if ($method === 'POST') {
            $requestData = $_POST;
        } else {
            $requestData = $_GET;
        }

        unset($requestData['route']);

        $ref = new \ReflectionMethod($controllerObject, $actionName);
        $allowedParams = $ref->getParameters();

        $callArgs = [];
        foreach ($allowedParams as $param) {
            $name = $param->getName();
            if (isset($requestData[$name])) {
                $callArgs[] = $requestData[$name];
            } elseif ($param->isDefaultValueAvailable()) {
                $callArgs[] = $param->getDefaultValue();
            } else {
                $callArgs[] = null;
            }
        }

        $data = $controllerObject->$actionName(...$callArgs);
        if (!empty($data)) {
            $this->mainTtemplate->addParams($data);
        }
    }
    public function setLayout(string $layoutPath): void
    {
        $this->mainTtemplate = new Template($layoutPath);
    }


    public function error($code)
    {
        http_response_code($code);

        $template = new Template('views/errors/404.php');

        switch ($code) {
            case 404:
                $this->mainTtemplate->addParam('content', $template->render());
                break;
        }
    }

    public function done()
    {
        $this->mainTtemplate->display();
    }
}
