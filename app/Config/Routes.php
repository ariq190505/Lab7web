<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);

$routes->get('/', 'Home::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::view/$1');
$routes->get('/kategori/(:any)', 'Kategori::view/$1');
$routes->get('/testdb', 'Page::testdb');
$routes->get('/createdb', 'Page::createdb');
$routes->get('/databasetest', 'DatabaseTest::index');
$routes->get('/databasetest/create', 'DatabaseTest::createTables');

// Admin routes
$routes->group('admin', function($routes) {
    // Artikel routes
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');

    // Kategori routes
    $routes->get('kategori', 'Kategori::admin_index');
    $routes->add('kategori/add', 'Kategori::add');
    $routes->add('kategori/edit/(:any)', 'Kategori::edit/$1');
    $routes->get('kategori/delete/(:any)', 'Kategori::delete/$1');
});
