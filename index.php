<?php
/**
 * 
 * Require files
 * 
 */
require_once __DIR__ . '/config/__init.php';
require_once __DIR__ . '/router/index.php';

/**
 * 
 * new instanse of router
 * 
 */
$router = new Router();

/**
 * 
 * handle / route
 * 
 */
$router->get('/','index.php');
/**
 * 
 * handle / route
 * 
 */
$router->get('/home','index.php');
$router->get('/dashboard','dashboard.php');
$router->get('/login','login.php');
$router->get('/register','register.php');
$router->get('/verifyuser','optionUsers.php');
$router->get('/resendemail','resend-email-verification.php');

$router->get('/barang','/PengelolaanBarang/index.php');
