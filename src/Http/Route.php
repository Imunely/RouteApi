<?php

namespace ApiRoute\Http;

class Route
{
    /**
     *
     * @var array
     */
    private static $prefix = '';

    public static function __init(callable $routes)
    {
        if (is_callable($routes)) {
            call_user_func($routes);
        }

        \ApiRoute\Http\Core\Response::err(404, 'Not Found');
    }

    /**
     *
     * @param string $filter string: 'user/{id}'
     * @param callable $callback
     * @return void
     */
    public static function get(string $filter, callable $callback, bool $auth = false)
    {
        if (
            \ApiRoute\Http\Core\Request::_isGet() && is_callable($callback) &&
            false !== ($map = (self::parse(self::$prefix . $filter, $_SERVER['REQUEST_URI'])))
        ) {
            $rq = new \ApiRoute\Http\Core\Request($map);
            if ($auth) new \ApiRoute\Http\Core\Auth($rq);
            call_user_func($callback, $rq, $rq->inner());

            exit;
        }
    }

    public static function post(string $filter, callable $callback, bool $auth = false)
    {
        if (
            \ApiRoute\Http\Core\Request::_isPost() && is_callable($callback) &&
            $map = (self::parse(self::$prefix . $filter, $_SERVER['REQUEST_URI']))
        ) {
            $rq = new \ApiRoute\Http\Core\Request($map);
            if ($auth) new \ApiRoute\Http\Core\Auth($rq);
            call_user_func($callback, $rq, $rq->inner());

            exit;
        }
    }

    public static function parse(string $route, string $query)
    {
        $route = preg_split('/[\/]/ui', $route, -1, PREG_SPLIT_NO_EMPTY);
        $query = preg_split('/[\/]/ui', $query, -1, PREG_SPLIT_NO_EMPTY);

        if (count($route) !== count($query)) return false;

        if (($route === $query) === []) {
            return [];
        }

        for ($i = 0; $i < count($route); $i++) {
            if ($route[$i][0] !== '{' && $route[$i] !== $query[$i]) {
                return false;
            }
        }

        return array_combine(str_replace(['{', '}'], '', $route), $query);
    }


    public static function truePrefix(string $prefix): int|false
    {
        return (preg_match('/^'.str_replace('/', '\/', $prefix).'/u', $_SERVER['REQUEST_URI']));
    }

    /**
     *
     * @return void
     */
    public static function group(string $prefix, callable $routes, bool $auth = false)
    {

        if (is_callable($routes) && self::truePrefix($prefix)) {

            self::$prefix = $prefix;

            if ($auth) new \ApiRoute\Http\Core\Auth(new \ApiRoute\Http\Core\Request());

            call_user_func($routes);
        }
    }
}
