<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//use this when you move my code into class files, i have not done this.
function my_autoloader($class)
{
    include 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');

//basically what you need to do is add routes, controllers, and the html template views to make the final project.

//Basic Steps:

//1. Add a route using the template action and method are the same name. Page and controller are the same name.
//2. Add a controller and/or add methods to a controller that match the actions
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
$response = processRequest::createResponse();


class routes
{

    public static function getRoutes()
    {
        //bellow adds routes to your program, routes match the URL and request method with the controller and method.
        //You need to follow this pattern to add new URLS
        //You should improve this function by making functions to create routes in a factory. I will look for this when grading

        //I also use object for the route because it has data and it's easier to access.
        $route = new route();

        //Specify the request method
        $route->http_method = 'GET';
        //specify the page.  index.php?page=index.  (controller name / method called
        $route->page = 'index';
        //specify the action that is in the URL to trigger this route index.php?page=index&action=show
        $route->action = 'show';
        //specify the name of the controller class that will contain the functions that deal with the requests
        $route->controller = 'index';
        //specify the name of the method that is called, the method should be the same as the action
        $route->method = 'show';
        //this adds the route to the routes array.
        $routes[] = $route;


        //This is an examole of the post for index
        $route = new route();
        $route->http_method = 'POST';
        $route->action = 'create';
        $route->page = 'index';
        $route->controller = 'index';
        $route->method = 'create';
        $routes[] = $route;

        //This is an examole of the post for tasks to show a task

        $route = new route();
        $route->http_method = 'GET';
        $route->action = 'show';
        $route->page = 'tasks';
        $route->controller = 'tasks';
        $route->method = 'show';
        $routes[] = $route;

        //This is an examole of the post for tasks to list tasks.  See the action matches the method name.
        //you need to add routes for create, edit, and delete

        $route = new route();
        $route->http_method = 'GET';
        $route->action = 'list_task';
        $route->page = 'tasks';
        $route->controller = 'tasks';
        $route->method = 'list_task';
        $routes[] = $route;

        return $routes;
    }
}

//this is the route prototype object  you would make a factory to return this

class route
{
    public $page;
    public $action;
    public $method;
    public $controller;
}


class processRequest
{

    //this is the main function of the program to calculate the response to a get or post request
    public static function createResponse()
    {

        $requested_route = processRequest::getRequestedRoute();

        //This is an important function to look at, it determines which controller to use
        $controller_name = $requested_route->controller;
        //this determines the method to call for the controller
        $controller_method = $requested_route->method;

        //I use a static for the controller because it doesn't have any properties
        $controller_name::$controller_method();

    }

    //this function matches the request to the correct controller
    public static function getRequestedRoute()
    {

        //this is a helper function that needs to be improved because it does too much.  I will look for this in grading

        $request_method = request::getRequestMethod();
        $page = request::getPage();
        $action = request::getAction();
        echo 'Action: ' . $action . '</br>';
        echo 'Page: ' . $page . '</br>';
        echo 'Request Method: ' . $request_method . '</br>';

        //this gets the routes objects, you need to add routes to add pages and follow the template of the route specified
        $routes = routes::getRoutes();

        //this figures out which route matches the page being requested in the URL and returns it so that the controller and method can be called
        foreach ($routes as $route) {

            if ($route->page == $page && $route->http_method == $request_method && $route->action == $action) {
               return $route;
             }


        }
    }

}


//this is the controller class that you use to connect models with views and business logic
class controller
{


//this gets the HTML template for the application and accepts the model.  The model array can be used in the template
    static public function getTemplate($template, $data = NULL)
    {

        $template = 'pages/' . $template . '.php';
        //in your template you should use $data to access your array
        include $template;

    }
}


//this is the controller for the index page.

//You are going to need to create a auth controller that deals with login and registration you should not submit the post for the to the index controller
//POST index.php?page=auth?action=create for adding a user
//POST index.php?page=auth?action=login for logging a  user in and get the userID out of the session
//POST index.php?page=auth?action=logout  this would destroy the session and return the user to the homepage
//GET  index.php?page=auth?action=show  this would be to show the user profile and you get the userID out of session




class index extends controller
{

    public static function show()
    {
        //this is the show method that is called to show the sites name in a template any array passed in will be accepted by the template function as a model

        $myTemplateData = array('site_name' => 'My Task Site');

        //You could get fancy with the homepage and check for the userID in the session and hide/show the login / registration links when no session
        //If there is a session then you should show the user profile link
        //the template is an HTML page with PHP inserted in it.  just put an if/else statement to check for the session and show correct links
        self::getTemplate('homepage', $myTemplateData);
    }

    public static function create()
    {

        //I just put a $_POST here but this is where you would put the code to add a record
        print_r($_POST);
    }

}




//each page extends controller and the index.php?page=tasks causes the controller to be called
class tasks extends controller
{

    //each method in the controller is named an action.
    //to call the show function the url is index.php?page=task&action=show
    public static function show()
    {
        $myTemplateData = array('site_name' => 'My Task Site', 'page_name' => 'task');

        self::getTemplate('tasks', $myTemplateData);
    }

    //to call the show function the url is index.php?page=task&action=list_task

    public static function list_task()
    {
        $myTemplateData = array('site_name' => 'My d Task Site', 'page_name' => 'task list');

        self::getTemplate('tasks', $myTemplateData);

    }
    //to call the show function the url is called with a post to: index.php?page=task&action=create
    //this is a function to create new tasks

    //you should check the notes on the project posted in moodle for how to use active record here

    public static function create()
    {
        print_r($_POST);
    }

    //this is the function to edit records
    public static function edit()
    {
        print_r($_POST);

    }

    //this is the delete function.  You actually return the edit form and then there should be 2 forms on that.
    //One form is the todo and the other is just for the delete button
    public static function remove()
    {
        print_r($_POST);

    }

}


class request
{


    //this gets the request method to make it easier to use
    static public function getRequestMethod()
    {
        $request_method = $_SERVER['REQUEST_METHOD'];
        return $request_method;
    }

    //this gets determines the page

    static public function getPage()
    {
        //this sets the default page for the app to index
        $page = 'index';

        //this checks if page is set
        if (!empty($_GET['page'])) {
            $page = $_GET['page'];
        }
        return $page;
    }

    //this gets the action out of the URL
    static public function getAction()
    {

        //this is a litte code to help the homepage handle post requests if needed
        if (self::getRequestMethod() == 'POST') {
            $action = 'create';


        } else {
            $action = 'show';
        }


        if (!empty($_GET['action'])) {
            $action = $_GET['action'];
        }
        return $action;
    }
}


?>
