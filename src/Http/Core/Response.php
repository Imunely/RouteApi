<?php

namespace ApiRoute\Http\Core;

class Response
{

    protected $build = [
        'data' => '',
        'code' => 200,
        'msg' => 'OK',
        'type' => 'application/json',
        'header' => [],
        'redirect' => [],
    ];

    public static function ok(mixed  $data = [])
    {
        $r = new Response();

        return self::send(
            json_encode($data),
            httpHeaders: array(
                'Content-Type: ' . $r->build['type'],
                $_SERVER["SERVER_PROTOCOL"] . ' 200 OK'
            )
        );
    }

    public static function err(int $code = 500, string $msg = 'Internal Server Error')
    {
        $r = new Response();

        return self::send(
            httpHeaders: array_merge(
                $r->build['header'],
                [
                    'Content-Type: ' . $r->build['type'],
                    $_SERVER["SERVER_PROTOCOL"] . ' ' . $code . ' ' . $msg
                ]
            )
        );
    }


    public static function set(callable $fun)
    {
        if (!is_callable($fun)) {
            throw new \Exception("{$fun} must be callable", 1);
        }

        call_user_func($fun, $r = new Response());


        return self::send(
            self::isJson($r->build['data']) ? $r->build['data'] : json_encode($r->build['data']),
            array_merge(
                $r->build['header'],
                $r->build['redirect'],
                [
                    $_SERVER["SERVER_PROTOCOL"] . ' ' . $r->build['code'] . ' ' . $r->build['msg'],
                    'Content-Type: ' . $r->build['type'],
                ]
            )
        );
    }


    function code(string|int $code)
    {
        $this->build[__FUNCTION__] = $code;

        return $this;
    }

    function msg(string|int $msg)
    {
        $this->build[__FUNCTION__] = $msg;

        return $this;
    }

    function data(mixed $data)
    {
        $this->build[__FUNCTION__] = $data;

        return $this;
    }

    function header(array $header)
    {
        $this->build[__FUNCTION__] = $header;

        return $this;
    }

    function type(string $type)
    {
        $this->build[__FUNCTION__] = $type;

        return $this;
    }

    public function redirect(string $url)
    {
        $this->build[__FUNCTION__] = ['Location: ' . $url];
        $this->code(308)->msg('Permanent Redirect');

        return $this;
    }


    protected static function send(mixed $data = null, array $httpHeaders = [])
    {
        header_remove('Set-Cookie');

        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }

        if ($data) {
            echo $data;
        }

        exit;
    }

    protected static function isJson($string)
    {
        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}
