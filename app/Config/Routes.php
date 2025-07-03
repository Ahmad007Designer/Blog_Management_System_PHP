<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */



$routes->addRedirect('/', 'users/login');
$routes->get('users/login', 'Auth::login');
$routes->get('users/register', 'Auth::signup');
$routes->post('users/register', 'Auth::register');
$routes->post('users/login', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');

//For post-route

//(Only for logged-in users)
$routes->group('posts', ['filter' => 'auth'], function($routes) {
    $routes->get('list', 'Post::index');
    $routes->post('list', 'Post::store');
    $routes->post('store', 'Post::store');
    $routes->get('my-posts', 'Post::myPosts');
    $routes->post('my-posts', 'Post::myPosts');
    $routes->get('create', 'Post::createView');
    $routes->post('create', 'Post::createPost');

    $routes->get('view/(:num)', 'Post::view/$1');
    $routes->get('edit/(:num)', 'Post::editPost/$1');
    $routes->post('update/(:num)', 'Post::update/$1');
    $routes->get('delete/(:num)', 'Post::delete/$1');

    $routes->get('save', 'Post::savePost');    
    // $routes->post('delete/(:num)', 'Post::delete/$1');
    $routes->get('author/(:any)', 'Post::authorPosts/$1');
});
$routes->match(['post', 'delete'], 'posts/delete/(:num)', 'Post::delete/$1');
$routes->get('posts/view_ajax/(:num)', 'Post::view_ajax/$1');
$routes->get('posts/edit_ajax/(:num)', 'Post::edit_ajax/$1');
$routes->post('posts/update_ajax/(:num)', 'Post::update_ajax/$1');







