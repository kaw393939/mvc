<?php

//this is the controller for the index page.

//You are going to need to create a auth controller that deals with login and registration you should not submit the post for the to the index controller
//POST index.php?page=auth?action=create for adding a user
//POST index.php?page=auth?action=login for logging a  user in and get the userID out of the session
//POST index.php?page=auth?action=logout  this would destroy the session and return the user to the homepage
//GET  index.php?page=auth?action=show  this would be to show the user profile and you get the userID out of session




class homepage extends http\controller
{

public static function show()
{
//this is the show method that is called to show the sites name in a template any array passed in will be accepted by the template function as a model

$myTemplateData = array('site_name' => 'My Task Site');

//You could get fancy with the homepage and check for the userID in the session and hide/show the login / registration links when no session
//If there is a session then you should show the user profile link
//the template is an HTML page with PHP inserted in it.  just put an if/else statement to check for the session and show correct links
    //$form .= '<h2>Select All Records</h2>';
    $records = accounts::findAll();
    print_r($records);
    //$tableGen = htmlTable::genarateTableFromMultiArray($records);
    //$form .= $tableGen;
    //$myTemplateData = $form;


    self::getTemplate('homepage', $records);
}

public static function create()
{
    $record = new account();
    $record->email="kwilliam@njit.edu";
    $record->fname="test2";
    $record->lname="cccc2";
    $record->phone="4444444";
    $record->birthday="0";
    $record->gender="male";
    $record->password="12345";
    $record->save();



//I just put a $_POST here but this is where you would put the code to add a record
print_r($_POST);
}

}
