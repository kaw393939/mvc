<?php
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 11/27/17
 * Time: 5:32 PM
 */


//each page extends controller and the index.php?page=tasks causes the controller to be called
class tasks extends http\controller
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