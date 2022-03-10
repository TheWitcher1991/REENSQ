<?php
namespace Reensq\plugin\core;

use Reensq\plugin\lib\jQuery;

/**
 * Interface LoggerRouter
 * Интерфейс класса Router
 *
 * @package Reensq\Plugin\core
 * @file source/vendor/MVC/core/Router.php
 * @author Reensq foundation
 */
interface LoggerRouter {

    /**
     * Проверяем объект self
     *
     * @return object|DB
     */
    public static function instance();

    /**
     * Добавляет маршрут в таблицу
     *
     * @param string $regExp регуляное выражение маршрута
     * @param array $route маршрут ([controller, action, params])
     */
    public static function add($regExp, $route = []);

    /**
     * Возвращает таблицу маршрутов
     *
     * @return array
     */
    public static function getRoutes() : array;

    /**
     * Возвращает текущий маршрут
     *
     * @return array
     */
    public static function getRoute() : array;

    /**
     * Ищет URL в таблицу маршрутов
     *
     * @param string $url входящий URL
     * @return bool
     */
    public static function matchRoute($url);

    /**
     * Перенаправляет URL по корректному маршруту
     *
     * @param string $url входящий UR
     */
    public static function disPatch($url);

}

/**
 * Class Router
 *
 * Это класс для создания маршрутизатор
 *
 * @package Reensq\plugin\core
 * @author Reensq foundation
 */
class Router implements LoggerRouter {

    /**
     * Таблица маршрутов
     *
     * @var array
     */
    protected static $routes = [];

    /**
     * Текущий маршрут
     *
     * @var array
     */
    protected static $route = [];

    /**
     * Массив с ошибками
     *
     * @var array
     */
    protected static $error = [];

    /**
     * Объект для класса self
     *
     * @var object
     */
    protected static $instance;

    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public static function add($regExp, $route = []) {
        self::$routes[$regExp] = $route;
    }

    public static function getRoutes() : array {
        return self::$routes;
    }

    public static function getRoute() : array {
        return self::$route;
    }

    public static function matchRoute($url) {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }

                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }

                self::$route = $route;
                return true;
            }
        }

        return false;
    }

    public static function disPatch($url) {
        $url = self::removeQueryString($url);

        if (self::matchRoute($url)) {
            $controller = __DIR__ . self::$route['controller'];

            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action'] . 'Action');

                if (method_exists($cObj, $action)) {
                    $cObj::$action();
                } else {
                    self::$error .= 'Метод ' . $action . ' у контроллера ' . $controller . ' Не найден';
                }
            } else {
                self::$error .= 'Контроллер ' . $controller . ' Не найден';
            }
        } else {
            http_response_code(404);
            include 'layout/404.php';
        }
    }

    /**
     * Преобразует имена к виду CamelCase
     *
     * @param string $name строка для преобразования
     * @return string
     */
    protected static function upperCamelCase($name) {
        return str_replace(' ', '', ucwords(str_replace('-', '', $name)));
    }

    /**
     * Преобразует имена к виду CamelCase
     *
     * @param string $name строка для преобразования
     * @return string
     */
    protected static function lowerCamelCase($name) {
        return lcfirst(self::upperCamelCase($name));
    }

    /**
     * Возвращает строку без GET параметров
     *
     * @param string $url запрос URL
     * @return bool|string
     */
    protected static function removeQueryString($url) {
        if ($url) {
            $params = explode('&', $url, 2);

            if (false === strpos($params[0], '=')) {
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        } else {
            return false;
        }
    }

}