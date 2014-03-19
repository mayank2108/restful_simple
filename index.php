<?php

include_once('API.php');
include_once('Controller.php');
include_once('Products.php');
include_once('db.php');
include_once('oauth.php');

$restful=new RESTFUL();
$controller=ucfirst($restful->controller); //eg. change products to Products
$controller= new $controller;             // instantiate an object to a class eg Products or Oauth
$dbh=new db();                             //make an object for database

$controller->execute($restful);

