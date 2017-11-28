<?php
/**
 * Created by PhpStorm.
 * User: kwilliams
 * Date: 11/27/17
 * Time: 5:32 PM
 */


//each page extends controller and the index.php?page=tasks causes the controller to be called
class accountsController extends http\controller
{

    //each method in the controller is named an action.
    //to call the show function the url is index.php?page=task&action=show
    public static function show()
    {
        $record = accounts::findOne($_REQUEST['id']);
        self::getTemplate('show_account', $record);
    }

    //to call the show function the url is index.php?page=task&action=list_task

    public static function all()
    {

        $records = accounts::findAll();
        self::getTemplate('all_accounts', $records);

    }
    //to call the show function the url is called with a post to: index.php?page=task&action=create
    //this is a function to create new tasks

    //you should check the notes on the project posted in moodle for how to use active record here

    //this is to register an account i.e. insert a new account
    public static function register()
    {
        print_r($_POST);
        //this just shows creating an account.
        $record = new account();
        $record->email="kwilliam@njit.edu";
        $record->fname="test2";
        $record->lname="cccc2";
        $record->phone="4444444";
        $record->birthday="0";
        $record->gender="male";
        $record->password="12345";
        $record->save();
    }

    //this is the function to save the user the user profile
    public static function store()
    {
        print_r($_POST);

    }

    public static function edit()
    {
        $record =  accounts::findOne($_REQUEST['id']);

        self::getTemplate('edit_account', $record);

    }

    //this is to login, here is where you find the account and allow login or deny.
    public static function login()
    {
        print_r($_POST);

    }

}