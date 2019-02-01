<?php
//Turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);
session_start();

//Require autoload
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG',3);

//Define a default route
$f3->route('GET /', function()
{
    //echo '<h1>Hello, World!</h1>';

    $view = new View;
    echo $view->render('views/home.html');
});

//Define a personal info route
$f3->route('GET /personal', function(){
    $view = new View();
    echo $view->render('views/form1.html');
});

//Define a profile route
$f3->route('GET /profile', function(){
    $view = new View();
    echo $view->render('views/form2.html');
});

//Define a interests route
$f3->route('GET /interests', function(){
    $view = new View();
    echo $view->render('views/form3.html');
});

//Define a summary route
$f3->route('GET /summary', function(){
    $view = new View();
    echo $view->render('views/summary.html');
});

//Run fat free
$f3->run();


