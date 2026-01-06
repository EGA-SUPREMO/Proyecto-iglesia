<?php

require_once 'modelo/App.php';
require_once 'modelo/Router.php';

App::iniciar();
$pdo = App::obtenerConexion();
BaseDatos::hacerRespaldo($pdo, $_ENV['DB_DIR_BACKUP']);

$router = new Router($pdo);
$router->despachar();
