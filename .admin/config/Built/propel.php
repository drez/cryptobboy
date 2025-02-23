<?php

namespace App;


if(file_exists(__DIR__ .'/'. $_SERVER['SERVER_NAME'].'.php')){
    \Propel::init(__DIR__ .'/'. $_SERVER['SERVER_NAME'].'.php');
}else{
    \Propel::init(__DIR__ . '/db.php');
    $_SESSION['loader'] = ['db' => 'default'];
}


global $con;
$con = \Propel::getConnection('cryptobboy');
