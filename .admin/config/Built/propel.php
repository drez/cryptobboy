<?php

namespace App;


\Propel::init(__DIR__ . "/db.php");

global $con;
$con = \Propel::getConnection('cryptobboy');
