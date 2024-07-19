<?php
function env ($key, $default=null) {
    $env = file_get_contents(".env");
    $envs = explode("\n", $env);
    $env_array = [];
    foreach ($envs as $env) {
        $env = explode("=", $env, 2);
        $env_array[trim($env[0])] = trim($env[1]);
    }
    return isset($env_array[$key]) ? $env_array[$key] : (isset($default) ? $default : null);
}