<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

//use this when you move my code into class files
function my_autoloader($class)
{
    include 'classes/' . $class . '.class.php';
}

spl_autoload_register('my_autoloader');


//this starts the program as a static
$response = processRequest::createResponse();

//to get credit for using this as MVC you must rewrite what I give and improve it.
//  A good way to improve it is namespaces and making the scope of properties and functions to be correctly private, public, or protected
//there are notes throughout the code on improvements.  YOu can also correctly apply abstract and final
//you can also look for lines that can be removed by just doing it in the return
//it shouldn't be too hard to namespace and provide interfaces


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
        //specify the page.  This is a simple MVC and only supports urls like index.php?page=index.
        $route->url = 'index';
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
        $route->url = 'index';
        $route->controller = 'index';
        $route->method = 'create';
        $routes[] = $route;

        //This is an examole of the post for tasks to show a task

        $route = new route();
        $route->http_method = 'GET';
        $route->action = 'show';
        $route->url = 'tasks';
        $route->controller = 'tasks';
        $route->method = 'show';
        $routes[] = $route;

        //This is an examole of the post for tasks to list tasks.  See the action matches the method name.
        //you need to add routes for create, edit, and delete

        $route = new route();
        $route->http_method = 'GET';
        $route->action = 'list_task';
        $route->url = 'tasks';
        $route->controller = 'tasks';
        $route->method = 'list_task';
        $routes[] = $route;

        return $routes;
    }
}

//this is the route prototype object  you would make a factory to return this

class route
{
    public $url;
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
        $url = request::getURL();
        $action = request::getAction();
        echo 'Action: ' . $action . '</br>';
        echo 'URL: ' . $url . '</br>';
        echo 'Method: ' . $request_method . '</br>';

        $routes = routes::getRoutes();

        foreach ($routes as $route) {

            if ($route->url == $url && $route->http_method == $request_method && $route->action == $action) {
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

    static public function getURL()
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
