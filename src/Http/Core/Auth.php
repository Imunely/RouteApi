<?php

namespace ApiRoute\Http\Core;

class Auth
{
    /**
     *
     * @var \ApiRoute\Http\Core\Request
     */
    private $request;

    public function __construct(\ApiRoute\Http\Core\Request $request)
    {

        $this->request = $request;

        $this->is_auth($request->headers());
    }


    public function is_auth(object $headers)
    {
        if (!isset($headers->client_id) || !isset($headers->client_private) || !isset($headers->timestamp)) {

            return Response::err(403, 'Forbidden');
        }
        
        

        if (!$inner = array_filter(
            api,
            fn ($item) =>
            $item['client_id'] === $headers->client_id
                &&
                $this->build_hmac($headers->timestamp, $item['client_private'], $headers->client_id) === $headers->client_private
        )) {

            return Response::set(
                fn (\ApiRoute\Http\Core\Response $r) =>
                $r->data(['error' => 'Invalid authorization key'])->code(401)->msg('Unauthorized')
            );
        }

        return $inner;
    }


    private function build_hmac(string $time, string $privateInner, string $publicInner): string
    {
        $data = $this->request->input();

        return hash_hmac('sha512', "$privateInner$time$data", $publicInner);
    }
}
