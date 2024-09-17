<?php
$router['/'] = ['controller' => 'HomeController', 'method' => 'index', 'params' => [], 'action' => 'GET'];
$router['/user'] = ['controller' => 'UserController', 'method' => 'login', 'params' => [], 'action' => 'ANY'];
$router['/user/register'] = ['controller' => 'UserController', 'method' => 'register', 'params' => [], 'action' => 'ANY'];
