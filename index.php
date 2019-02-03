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

// set valid indoor/outdoor choice arrays
$f3->set('indoors', array('tv','movies','cooking','board_games','puzzles','reading','playing_cards','video_games'));
$f3->set('outdoors', array('hiking','biking','swimming','collecting','walking','climbing'));

require('model/validate.php');

//Define a default route
$f3->route('GET /', function()
{
    $view = new View;
    echo $view->render('views/home.html');
});

//Define a personal info route
$f3->route('GET|POST /personal', function($f3){


    // reset session array
    $_SESSION = array();

    if(isset($_POST)){

        $isValid = true;

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $age = $_POST['age'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        if(validName($fname) AND validName($lname)){

            $_SESSION['name'] = $fname." ".$lname;

        }else{
            $isValid = false;
            //$f3->set("errors['name'}", "Please enter a isValid name, no spaces, numbers, or special characters.");
        }

        if (validAge($age)) {
            $_SESSION['age'] = $age;
        }else{
            $isValid = false;
            //$f3->set("errors['age'}", "This site is for adults only, Please enter a isValid age.");
        }

        if (validPhone($phone)) {
            $_SESSION['phone'] = $phone;
        }else{
            $isValid = false;
            //$f3->set("errors['phone'}", "Please enter a isValid phone number.");
        }

        if(empty($_POST['gender'])) {
            $_SESSION['gender'] = "N/A";
            //$f3->set("errors['gender'}", "Please choose a gender.");
        }else{
            $_SESSION['gender'] = $gender;
        }
        if($isValid){
            $f3->reroute('/profile');
        }

    }


    $view = new Template();
    echo $view->render('views/form1.html');
});

//Define a profile route
$f3->route('GET|POST /profile', function($f3){

    if(isset($_POST)){

        $isValid = true;

        $email = $_POST['email'];
        $state = $_POST['state'];
        $seeking = $_POST['seeking'];
        $bio = "";

        if(!empty($email)){

            $_SESSION['email'] = $email;

        }else{
            $isValid = false;
            //$f3->set("errors['email'}", "Please enter a email address.");
        }

        if (!empty($state)) {
            $_SESSION['state'] = $state;
        }else{
            $isValid = false;
            //$f3->set("errors['state'}", "This site is intended for people living in the U.S.
            // Please provide a valid state");
        }

        if (!empty($_POST['bio'])) {
            $_SESSION['bio'] = $bio;
        }else{
            $_SESSION['bio'] = "Mysterious";
            //$f3->set("errors['phone'}", "Please enter a isValid phone number.");
        }

        if(empty($_POST['seeking'])) {
            $_SESSION['seeking'] = "N/A";
            //$f3->set("errors['seeking'}", "Please choose the gender(s) you are seeking.");
        }else{
            $_SESSION['seeking'] = $seeking;
        }
        if($isValid){
            $f3->reroute('/interests');
        }
        print_r($_SESSION);


    }
    $view = new Template();
    echo $view->render('views/form2.html');
});

//Define a interests route
$f3->route('GET|POST /interests', function($f3){
    $view = new Template();
    echo $view->render('views/form3.html');
});

//Define a summary route
$f3->route('GET|POST /summary', function($f3){

    $f3->set('name',$_SESSION['name']);
    $f3->set('gender', $_SESSION['gender']);
    $f3->set('age',$_SESSION['age']);
    $f3->set('phone', $_SESSION['phone']);
    $f3->set('email', $_SESSION['email']);
    $f3->set('state', $_SESSION['state']);
    $f3->set('seeking', $_SESSION['seeking']);
    $f3->set('bio', $_SESSION['bio']);
    //$f3->set('interests',$_SESSION['interests']);

    $view = new Template();
    echo $view->render('views/summary.html');

    print_r($_SESSION);
});

//Run fat free
$f3->run();


