<?php

namespace http;

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
        $page = 'homepage';

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