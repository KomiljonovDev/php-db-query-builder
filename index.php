<?php
require 'vendor/autoload.php';

use Core\Models\User;
use Core\database\Query;


Query::setTable('users');


// Create example

//User::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);
//Query::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);

// Where example

//$data = Query::where('name', 'Komiljonov')->orWhere('id', '=', 37)->get();
//
//print_r($data);