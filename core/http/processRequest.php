<?php

namespace http;
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 11/27/17
 * Time: 5:20 PM
 */
//by using the use here you don't have to put http on each class in that namespace

class processRequest
{

    //this is the main function of the program to calculate the response to a get or post request
    public static function createResponse()
    {

        $requested_route = processRequest::getRequestedRoute();

        //this print r shows the requested route
        //print_r($requested_route);
        //This is an important function to look at, it determines which controller to use
        $controller_name = $requested_route->controller;
        //this determines the method to call for the controller
        $controller_method = $requested_route->method;

        //these echo helps figure out the controller name and method
        // echo $controller_name . '</br>';
        // echo $controller_method . '</br>';


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

        //these are helpful for figuring out the action and method being requested
        //echo 'Action: ' . $action . '</br>';
        //echo 'Page: ' . $page . '</br>';
        //echo 'Request Method: ' . $request_method . '</br>';

        //this gets the routes objects, you need to add routes to add pages and follow the template of the route specified
        $routes = \routes::getRoutes();
        $foundRoute = NULL;
        //this figures out which route matches the page being requested in the URL and returns it so that the controller and method can be called
        foreach ($routes as $route) {

            if ($route->page == $page && $route->http_method == $request_method && $route->action == $action) {
                $foundRoute = $route;
                break;
            }
        }
        if (is_null($foundRoute)) {
            controller::getTemplate('notfound');
            exit;
        } else {
            return $foundRoute;
        }
    }
}
