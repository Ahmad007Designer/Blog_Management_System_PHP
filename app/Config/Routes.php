<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

$routes->get('auth/register', 'Auth::signup');
$routes->get('auth/login', 'Auth::login');
// $routes->get('auth/home', 'Auth::home');
$routes->post('auth/register', 'Auth::register');
$routes->post('auth/login', 'Auth::authenticate');

$routes->get('logout', 'Auth::logout');

//For post-route


$routes->get('posts/create', 'Post::index');
$routes->post('posts/create', 'Post::createPost');
$routes->get('posts/list', 'Post::list');

$routes->get('posts/view/(:num)', 'Post::view/$1');


$routes->get('posts/save', 'Post::savePost');
$routes->get('posts/edit/(:num)', 'Post::editPost/$1');
$routes->post('posts/update/(:num)', 'Post::update/$1');
$routes->get('posts/delete/(:num)', 'Post::delete/$1');


