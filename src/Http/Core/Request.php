<?php

namespace ApiRoute\Http\Core;

class Request
{

    private  $build = [
        'url' => '',
        'data' => [],
        'headers' => '',
        'return_transfer' => 1,
    ];

    /**
     *
     * @var object
     */
    private $get;

    public function __construct(array $get = null)
    {
        $this->get = (object) $get;
    }

    public static function _send(callable $fun)
    {
        if (!is_callable($fun)) {
            throw new \Exception("{$fun} must be callable", 1);
        }

        call_user_func($fun, $r = new Request);


        return self::curl($r->build);
    }


    public static function _headers(): object
    {
        return (object) getallheaders();
    }

    public static function _get(): mixed
    {
        return json_decode(json_encode($_GET), false);
    }

    public static function _post(): mixed
    {
        return json_decode(json_encode($_POST), false);
    }

    public static function _isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public static function _isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function _dump(): object
    {
        return json_decode(json_encode(
            [
                'headers' => getallheaders(),
                'method' => $_SERVER['REQUEST_METHOD'],
                'uri' => $_SERVER['REQUEST_URI'],
                'data' => ['_input' => self::_input(), '_post' => $_POST, '_get' => $_GET]
            ]
        ), false);
    }

    public static function _input(): mixed
    {
        return file_get_contents('php://input');
    }

    public function headers(): object
    {
        return (object) getallheaders();
    }

    public function input()
    {
        return self::_input();
    }

    /**
     *
     * @return object|null|string|int|float
     */
    public function inner()
    {
        return $this->get;
    }

    public function post()
    {
        return self::_post();
    }

    public function get(): object
    {
        return self::_get();
    }

    public function url(string $url)
    {
        $this->build[__FUNCTION__] = $url;

        return $this;
    }

    public function data(array $data)
    {
        $this->build[__FUNCTION__] = json_encode($data);

        return $this;
    }


    public function header(array $headers)
    {
        $this->build[__FUNCTION__] = $headers;

        return $this;
    }

    public function return_transfer(bool|int $is)
    {
        $this->build[__FUNCTION__] = $is;

        return $this;
    }


    private static function curl(array $params)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $params['url']);
        curl_setopt($ch, CURLOPT_POST, $params['data'] ? 1 : 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $params['return_transfer']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $params['header'] ?? []);
        if ($params['data']) curl_setopt($ch, CURLOPT_POSTFIELDS, $params['data']);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output;
    }
}
