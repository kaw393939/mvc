<?php
class Manage
{
public static function core($class)
{

//this is useful to see what class and namespace is being asked for
//echo $class . '<br>';


$path = 'core/' . str_replace('\\', '/', $class) . '.php';
//this is useful to see what path is being asked for

//echo $path . '<br>';

if (is_file($path)) {
include $path;
return;
}
}

public static function controllers($class)
{

//this is useful to see what class and namespace is being asked for
//echo $class . '<br>';
$path = 'controllers/' . str_replace('\\', '/', $class) . '.php';
//this is useful to see what path is being asked for

//echo $path . '<br>';
if (is_file($path)) {
include $path;
return;
}
}

public static function models($class)
{

//this is useful to see what class and namespace is being asked for
//echo $class . '<br>';
$path = 'models/' . str_replace('\\', '/', $class) . '.php';
//this is useful to see what path is being asked for

//echo $path . '<br>';
if (is_file($path)) {
include $path;
return;
}
}

public static function collections($class)
{

//this is useful to see what class and namespace is being asked for
//echo $class . '<br>';
$path = 'collections/' . str_replace('\\', '/', $class) . '.php';
//this is useful to see what path is being asked for

//echo $path . '<br>';
if (is_file($path)) {
include $path;
return;
}
}

public static function routes($class)
{

//this is useful to see what class and namespace is being asked for
//echo $class . '<br>';
$path = 'routes/' . str_replace('\\', '/', $class) . '.php';
//this is useful to see what path is being asked for

//echo $path . '<br>';
if (is_file($path)) {
include $path;
return;
}
}
}

spl_autoload_register(array('Manage', 'routes'));


spl_autoload_register(array('Manage', 'controllers'));
spl_autoload_register(array('Manage', 'collections'));
spl_autoload_register(array('Manage', 'models'));
spl_autoload_register(array('Manage', 'core'));