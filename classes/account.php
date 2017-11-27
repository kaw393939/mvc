<?php
class account extends \database\model {
    public $id;
    public $email;
    public $fname;
    public $lname;
    public $phone;
    public $birthday;
    public $gender;
    public $password;
    protected static $modelName = 'account';
    public static function getTablename(){

        $tableName='accounts';
        return $tableName;
    }
}

?>
