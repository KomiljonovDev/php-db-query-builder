<?php
require 'vendor/autoload.php';

use Core\Models\User;
use Core\database\Query;

//var_dump(Query::create());
User::create(['name'=>'Obidjon', 'email'=>'obidjon@gmail.com']);

