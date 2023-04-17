<?php
require 'vendor/autoload.php';

use ApiRoute\Http\Core\Request;


class Calls
{
    public static function run()
    {
        return ([

            // Route::get('/')
            Request::_send(fn (Request $r) => $r->url('http://127.0.0.1:8786/')),

            // Route::get('page/{page}')
            Request::_send(fn (Request $r) => $r->url('http://127.0.0.1:8786/page/2')),

            // Route::post('/delete/{id}')
            Request::_send(fn (Request $r) => $r->url('http://127.0.0.1:8786/delete/23')->data(['auth_user' => 'Bona'])),


            Request::_send(fn (Request $r) => $r->url('http://127.0.0.1:8786/admin')
                ->header([
                    'Content-Type: application/json',
                    'client_id: ihDGUW8374gGJGy37374gJGHG7737ybdjaJBJ',
                    'client_private: ' . hash_hmac('sha512', 'i!hD*G_U!W83&74gG$JG:y3#7374JgJG_HG773!7y_bd:jaJBJ' . time(), 'ihDGUW8374gGJGy37374gJGHG7737ybdjaJBJ'),
                    'timestamp: ' . time()
                ])),

            var_dump(json_encode([0 => 'its api url'])),


            Request::_send(fn (Request $r) => $r->url('http://127.0.0.1:8786/api')
                ->data(['its api url'])
                ->header([
                    'Content-Type: application/json',
                    'client_id: ihDGUW8374gGJGy37374gJGHG7737ybdjaJBJ',
                    'client_private: ' . hash_hmac('sha512', 'i!hD*G_U!W83&74gG$JG:y3#7374JgJG_HG773!7y_bd:jaJBJ' . time() . json_encode(['its api url']), 'ihDGUW8374gGJGy37374gJGHG7737ybdjaJBJ'),
                    'timestamp: ' . time()
                ])),

            // Route::get('/api/user/{id}')
            Request::_send(fn (Request $r) => $r->url('http://127.0.0.1:8786/api/user/2')
                ->header([
                    'Content-Type: application/json',
                    'client_id: ihDGUW8374gGJGy37374gJGHG7737ybdjaJBJ',
                    'client_private: ' . hash_hmac('sha512', 'i!hD*G_U!W83&74gG$JG:y3#7374JgJG_HG773!7y_bd:jaJBJ' . time(), 'ihDGUW8374gGJGy37374gJGHG7737ybdjaJBJ'),
                    'timestamp: ' . time()
                ])),
        ]);
    }
}

print_r(Calls::run());
