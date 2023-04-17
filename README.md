# RouteApi

### Simple library for easy generation of endpoints and work with API HTTP ROUTE

## Usage Route
```php
Route::get('/', fn () => Response::ok()),
```
Withs params:
```php
Route::get('/user/{id}', fn ($r, $url) => Response::ok($url->id)),
```
=
```php
Route::get('/user/{id}', fn (Request $r) => Response::ok($r->inner()->id)),
```

Callback function contain params ``.., fn(Request $request, object $parsedUrl)``

### Route static methods 
```php
Route::__init(callable $routes)
```
```php
Route::get(string $filter, callable $callback, bool $auth = false): never
```
```php
Route::post(string $filter, callable $callback, bool $auth = false): never
```
```php
Route::group(string $prefix, callable $routes, bool $auth = false): never
```

### Example group routes with ``$prefix`` and ``$auth: hmac[sha512]``
```php
Route::group('/api', auth: true, routes: fn () => [

        /**
         * Its equel http://example.com/api 
         */
        Route::post('/', fn (Request $r) => print_r($r->headers())),

        /**
         * Its equel http://example.com/api/users/#id
         */
        Route::get('/user/{id}', fn ($r) => Response::ok($r->inner())),

]),
```

## Usage Request
#### The class ``Request::class`` contains a method for processing incoming requests, as well as for generating your own requests.
```php
Request::_post(): object
// return all post data from $_POST
```
```php
Request::_get(): object
// return all get data from $_GET
```
```php
Request::_input(): mixed
// return all other data from php://input
```
```php
Request::_headers(): object
// return all input http-headers
```
```php
Request::_isGet(): bool
// checks the method (HTTP GET)
```
```php
Request::_isPost(): bool
// checks the method (HTTP POST)
```
```php
Request::_dump(): object
// return
//[
//   'headers' => [allheaders],
//   'method' => GET|POST|PUT|etc,
//   'uri' => example.com/,
//   'data' => ['_input' => Request::_input(), '_post' => $_POST, '_get' => $_GET]
//]
```
### Usage outcoming request
```php
// Send post-http message with some header
Request::_send(fn (Request $r) => 
    $r->url('http://127.0.0.1/delete')
    ->data(['user' => 'Ivan Petrov'])
    ->header(['Content-Type: application/json'])),
```
### Outcoming methods
```php
Request->url(string $url): $this
```
```php
Request->header(array $headers): $this
```
```php
Request->data(array $data): $this
```
```php
Request->return_transfer(bool|int $is): $this
```
## Usage Response
#### The class ``Response::class`` is designed to form a response to incoming http requests.
#### It is similar to Request::class, but only serves incoming requests.
### Response 200
```php
Response::ok()

HTTP/1.1 200 OK
Host: 127.0.0.1:8786
Date: Mon, 17 Apr 2023 18:03:48 GMT
Connection: close
X-Powered-By: PHP/8.1.11
Content-Type: application/json
```
### Response 500
```php
Response::err()
// Send http Response 500

HTTP/1.1 500 Internal Server Error
Host: 127.0.0.1
Date: Mon, 17 Apr 2023 18:32:29 GMT
Connection: close
X-Powered-By: PHP/8.1.11
Content-Type: application/json
```
### Responce redirect
```php
Response::set(fn (Response $r) => $r->redirect('https://google.com')->code(301)) // default code 308

HTTP/1.1 301 Permanent Redirect
Host: 127.0.0.1
Date: Mon, 17 Apr 2023 18:37:19 GMT
Connection: close
X-Powered-By: PHP/8.1.11
Location: http://127.0.0.1/main
Content-Type: application/json
```
### User response
```php
Response::set(fn (Response $r) => $r->data("Hello world!")->code(203)->header(['Auth: close']))

HTTP/1.1 203 OK
Host: 127.0.0.1:8786
Date: Mon, 17 Apr 2023 18:42:09 GMT
Connection: close
X-Powered-By: PHP/8.1.11
Auth: close
Content-Type: application/json

"Hello world!"
```
### Response methods
```php
Response::ok(mixed $data = []): nener
```
```php
Response::err(int $code = 500, string $msg = 'Internal Server Error'): never
```
```php
Response::set(callable $fun): never
```
```php
Response->code(string|int $code): $this
```
```php
Response->msg(string|int $msg): $this
```
```php
Response->data(mixed $data): $this
```
```php
Response->msg(string|int $msg): $this
```
```php
Response->header(array $header): $this
```
```php
Response->type(string $type): $this
```
```php
Response->redirect(string $url): $this
```
```php
Request->return_transfer(bool|int $is): $this
```


