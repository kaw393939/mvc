<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


define('DATABASE', 'sd686');
define('USERNAME', 'sd686');
define('PASSWORD', 'ZOm1EN5l3');
define('CONNECTION', 'sql1.njit.edu');

//Autoloader class
class Manage {
    public static function autoload($class) {
        echo $class . '<br>';
        $path = 'classes/' .  str_replace('\\', '/', $class). '.php';
        echo $path . '<br>';
        include $path;
    }
}

spl_autoload_register(array('Manage', 'autoload'));


//To make the final project, you need to add routes, controllers, and the html templates in the "pages" folder.

//Basic Steps:

//1. Add a route using that matches the example routes in the program.  The action and method need to be the same name. Page and controller also need to be the same name.
//2. Add a controller and/or add methods to the controller, which match the actions that you want the program to perform.
//3. Add HTML view templates to the page folder.  Look at how the template is called and you can pass data to the template

//Suggested order of work:

//1.  Get findall working and displaying a table for the todos class's todos_list method;
//2.  Get findOne working to find one to-do and make that work for the todos controller show method.  Remember you have to pass the ID.
//3.  Get the Insert working
//4.  get the delete working
//5.  update working
//6.  once you have this all working for todos start working on accounts
//7.  once accounts works for login / logout / show user profile / edit profile
//8.  go back and add a useriD field to your todos table and update program accordingly i.e. the model
//9.  add a method to your to-do model that retrieves by userID instead of ID.  USe the findONe as an example
//10.  on your To-do-List method of the todos controller update it so that it takes the USER id out of the session and uses that to retrieve the todos



//to get credit for using this as MVC you must rewrite what I give and improve it.
//  A good way to improve it is namespaces and making the scope of properties and functions to be correctly private, public, or protected
//there are notes throughout the code on improvements.  YOu can also correctly apply abstract and final
//you can also look for lines that can be removed by just doing it in the return
//it shouldn't be too hard to namespace and autoload
//namespaces are really needed because your collection and controller classes for todos and accounts are called the same thing.


//IMPORTANT:  YOUR ACTIVE RECORD collection CLASSES  (task/account) WILL CONFLICT WITH THE CONTROLER CLASS HERE.
//You can use namespaces or rename the controller classes, which will change your url parameter for page

//routes are used to match the http request with the controller and method name that are called for that request / route.
//In this program the page parameter matches the controller and the action parameter matches the method on the conroller.
//Examples:

//  index.php?page=todos&action=show specifies the todos collection class and the show method/function


//  GET requests to show the  form for new todos should go to index.php?page=todos&action=create and show a form for a new todoItem
//  POST requests to create todos should go to index.php?page=todos&action=store and would be inserted into the database
//  GET requests to show the update form todos should go to index.php?page=todos&action=edit&id=(todoItem ID) and would show an update form
//  POST requests to update todos should go to index.php?page=todos&action=update&id=(todoItem ID) and would be update in the database
//  For delete you should put a delete button within a new form below the edit form that has a method post and action of index.php?page=todos&action=delete&id=(todoItem ID)

//You need to make an auth controller for handling user login, user registration, showing the profile, editing the profile, and logout
//Login should hash the password and compare it to the saved password hash
//registration should hash the password and insert the hashed password with the user record.  You should not store clear passwords in a database

//for the todos list page you need to make a table that has links to each item.
//  Like:  index.php?page=todos&action=show&id=1  this would show the to-do item with a link to the edit form.
//  you could put your delete on the to_do item view or the edit form, the above still applies.


//this starts the program as a static.  Start tracing the program from here following the classes and methods being called
$response = \http\processRequest::createResponse();

?>
