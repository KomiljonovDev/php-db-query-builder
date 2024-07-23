<?php
require 'vendor/autoload.php';

use Core\Models\User;
use Core\database\Query;


//Query::setTable('users');

// Create example

//User::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);
//Query::create(['name'=>'Obidjon', 'email'=>'komiljonovdev@gmail.com']);

// Where example

//$data = User::where('name', 'Komiljonov')->orWhere('id', '=', 37)->get();
//$data = Query::where('name', 'Komiljonov')->orWhere('id', '=', 37)->get();

//print_r($data);

// Update example

// Update all data
User::update(['name'=>'Obidjon Komiljonov','email'=>'komiljonovdev@gmail.com']);

// Update with where method
User::where('id','46')->orWhere('id', '45')->update(['name'=>'Obidjon Komiljonov','email'=>'komiljonovdev@gmail.com']);


// Get sql query
echo User::getQuery();