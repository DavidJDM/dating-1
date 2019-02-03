<?php
/**
 * Created by PhpStorm.
 * User: kcarl
 * Date: 2/1/2019
 * Time: 10:48 AM
 */


/**
 * @param string $name
 * @return boolean true if name is not empty and is alphabetic
 */

include('valid-states.php');


function validName($name){
    return $name != "" AND ctype_alpha($name);
}

function validAge($age){
    if($age == "") {
        return false;
    }

    return !is_nan($age)  AND $age >= 18;
}

function validPhone($phone){
    //eliminate every char except 0-9
    if(strlen($phone) > 11){
        $phone = preg_replace("[^0-9]", "",$phone);
    }

    //remove leading 1 if it's there
    if (strlen($phone) == 11) {
        $phone = preg_replace("/^1/", "",$phone);
    }

    return (strlen($phone)) === 10;
}

function validEmail($email){

    return filter_var($email, FILTER_VALIDATE_EMAIL);


}

function validState($state){
    global $validStates;
    return in_array($state, $validStates);
}

function validOutdoor($indoor){
    global $f3;
    return in_array($indoor,$f3->get('indoors'));
}

function validIndoor($outdoor){
    global $f3;
    return in_array($outdoor,$f3->get('outdoors'));
}
