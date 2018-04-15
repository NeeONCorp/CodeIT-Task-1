<?php

/**
 * Class Router
 *
 * Front Controller
 */
class Router
{

    # Список роутеров
    private $routes = [];

    public function __construct()
    {
        $this->routes = require_once(ROOT.'/config/routes.php');
        $this->run();
    }

    /**
     * Возвращает адрес запрашиваемой страницы
     *
     * @return string
     */
    private function getUri()
    {
        # Получаем запрос
        $uri = $_SERVER['REQUEST_URI'];
        $uri = $_SERVER['REQUEST_URI'];

        # Удаляем get параметры
        $uri = trim($uri, '/');
        $uri = explode('?', $uri)[0];

        # Получаем директорию проекта
        $pathApp =  App::getDirUrl();

        $uri = str_replace($pathApp, '', $uri);
        $uri = trim($uri, '/');

        return $uri;
    }


    private function run()
    {
        $uri = $this->getUri();
        $pageFound = false;

        foreach ($this->routes as $router => $path) {
            if (preg_match('~^' . $router . '$~', $uri)) {

                # Данные роутера
                $routerData = preg_replace('~^' . $router . '$~',
                    $path, $uri);

                $routerData = explode('/', $routerData);

                $controllerName = ucfirst($routerData[0]) . 'Controller';
                array_shift($routerData);

                $actionName = 'action' . ucfirst($routerData[0]);
                array_shift($routerData);

                # Аргуметы action
                $actionArgs = $routerData;
                unset($routerData);

                $controllerPath = ROOT . '/controllers/' . $controllerName . '.php';

                # Вызываем Controller - Action
                if(file_exists($controllerPath)) {
                    include_once $controllerPath;
                    $contrllerObj = new $controllerName();

                    if(method_exists($contrllerObj, $actionName)) {
                        call_user_func_array([$contrllerObj, $actionName], $actionArgs);
                    } else echo 'Action не найден';
                } else echo 'Controller не найден';

                $pageFound = true;
                break;
            }
        }

        if(!$pageFound) {
            App::pageNotFount();
        }
    }
}