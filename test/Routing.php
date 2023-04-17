<?php
require_once '../vendor/autoload.php';

use ApiRoute\Http\Core\Request;
use ApiRoute\Http\Core\Response;
use ApiRoute\Http\Route;

Route::__init(fn () => [

    /**
     * Root url
     * 
     * Its equel is 
     *
     * Route::get('/', function() {
     *     return Response::ok();
     * })
     */
    Route::get('/', fn () => Response::ok()),


    /**
     * Get page by id  
     * for example: http://example.com/page/13, http://example.com/page/23
     */
    Route::get(
        'page/{id}',
        fn (Request $r) => Response::set(fn (Response $res) => $res->data('Page is ' . $r->inner()->id)),
    ),

    /**
     * Return error 404 in header
     */
    Route::get('/oldpath', fn () => Response::err('404', 'Page not found')),


    /**
     * Use auth for route
     * algoritm hmac[sha512]
     * default responce: 403
     */
    Route::post('/delete/{id}', auth: 1, callback: fn (Request $r) => print_r($r->input())),


    Route::get('/admin', auth: 1, callback: fn () => Response::ok()),

    /**
     * Use [Route::group] with $prefix and $auth
     */
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

    // default: 404 Not Found
]);
