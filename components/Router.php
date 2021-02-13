<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }


    /**
     * Returns request string
     *
     * @return string
     */
    public function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])) {
            //dd($_SERVER['REQUEST_URI']);
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run(){
        //debug($this->routes);

        //Получить строку запроса:
        $uri = $this->getURI();

        //Проверка наличия такого запроса в роутах routes.php:
        foreach ($this->routes as $uriPattern => $path){
            //Сравнение $uriPattern и $uri
            if(preg_match("~$uriPattern~", $uri)){

//                debug(['uri' => $uri]);
//                debug(['uriPattern' => $uriPattern]);
//                debug(['path' => $path]);

                //Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("#$uriPattern#", $path, $uri);
                //ebug($internalRoute);

                //> Определим какой контроллер и экшн обрабатывают запрос:
                    //Разбиваем строку внутреннего запроса на элементы массива:
                    $segments = explode('/', $internalRoute);
                    //debug($segments);


                    //> Получаем имя контроллера
                    $controllerName = array_shift($segments) . 'Controller';
                    //debug($segments);

                    //debug($controllerName);
                    //Приводим к верхнему регистру первую букву:
                    $controllerName = ucfirst($controllerName);

                    //<

                    //Получаем имя экшена:
                    $actionName = 'action' . ucfirst(array_shift($segments));

//                    debug([
//                        'контроллер ' => $controllerName,
//                        'экшн' => $actionName
//                    ]);

                //<

                //Выбераем параметры оставшиеся в массиве $segments:
                $parameters = $segments;

               // debug($parameters);

                //> Подключаем файл класса-контроллера:

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                //Убеждаемся в наличии файла:
                if(file_exists($controllerFile)){
                    //подключаем
                    include_once $controllerFile;
                }
                //<

                //Создаем объект, вызываем метод - экшн:
                $controllerObject = new $controllerName;

                //dd($controllerObject);

                //$result = $controllerObject->$actionName();
                $result = call_user_func_array([$controllerObject, $actionName], $parameters);

                //dd($result);
                die;

                if($result != null) {
                    break;
                }


            }
        }

    }

}