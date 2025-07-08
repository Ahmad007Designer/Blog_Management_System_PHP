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
    $routes->post('list', 'Post::storePost');
    $routes->post('store', 'Post::storePost');
    $routes->get('my-posts', 'Post::myPosts');
    $routes->post('my-posts', 'Post::myPosts');
    $routes->get('create', 'Post::createView');
    
    $routes->get('author/(:any)', 'Post::authorPosts/$1');
    $routes->get('view_ajax/(:num)', 'Post::viewPost/$1');
    $routes->get('edit_ajax/(:num)', 'Post::editPost/$1');
    $routes->post('update_ajax/(:num)', 'Post::updatePost/$1');
    $routes->get('create_post', 'Post::create_post');
    $routes->match(['post', 'delete'], 'delete/(:num)', 'Post::deletePost/$1');
    
    // $routes->get('delete/(:num)', 'Post::delete/$1');
    // $routes->post('update/(:num)', 'Post::update/$1');
    // $routes->get('edit/(:num)', 'Post::editPost/$1');
    // $routes->get('view/(:num)', 'Post::view/$1');
    // $routes->post('create', 'Post::createPost');
    // $routes->get('save', 'Post::savePost');    
    // $routes->post('delete/(:num)', 'Post::delete/$1');
});







