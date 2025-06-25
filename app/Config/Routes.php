<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('auth/register', 'Auth::signup');
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/dashboard/home', 'Auth::home');
$routes->post('auth/register', 'Auth::register');
$routes->post('auth/login', 'Auth::authenticate');
$routes->post('upload/image', 'Upload::image');
$routes->get('logout', 'Auth::logout');
