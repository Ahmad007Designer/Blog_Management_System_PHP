<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->addRedirect('/', 'auth/login');
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/register', 'Auth::signup');
$routes->post('auth/register', 'Auth::register');
$routes->post('auth/login', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');

//For post-route

//(Only for logged-in users)
$routes->group('posts', ['filter' => 'auth'], function($routes) {
    $routes->get('list', 'Post::index');
    $routes->get('my-posts', 'Post::myPosts');
    $routes->get('create', 'Post::createView');
    $routes->post('create', 'Post::createPost');

    $routes->get('view/(:num)', 'Post::view/$1');
    $routes->get('edit/(:num)', 'Post::editPost/$1');
    $routes->post('update/(:num)', 'Post::update/$1');
    $routes->get('delete/(:num)', 'Post::delete/$1');

    $routes->get('save', 'Post::savePost');    
});

$routes->post('posts/delete/(:num)', 'Posts::delete/$1');



