<?php

namespace Catalyst;

/*
 * A class to manage the login info to MYSQL database
 * 
 * By making use of readFromFile function, writeToFile function and all 'get' functions, 
 * it is possible:
 *      1. print the info if there is input
 *      2. user doesnt need to enter the credential every single time
 * However, as it is not specified in the requirement, those functions are not used at the moment
 */
class MYSQLInfo{

    private const PATH = 'MYSQLInfo.txt';
    public static $infoArray = [
        'userName' => '',
        'password' => '',
        'serverName' => '',
    ];

    public static function getServerName() : String {
        return self::$infoArray['serverName'];
    }

    public static function getUserName() : String {
        return self::$infoArray['userName'];
    }

    public static function getPassword() : String{
        return self::$infoArray['password'];
    }

    public static function setServerName(String $serverName){
        self::$infoArray['serverName'] = $serverName;
    }

    public static function setUserName(String $userName){
        self::$infoArray['userName'] = $userName;
    }

    public static function setPassword(String $password){
        self::$infoArray['password'] = $password;
    }

    public static function readFromFile()
    {
        if(file_exists(self::PATH))
        {
            $array = file(self::PATH);
            self::setUserName($array[0]);
            self::setPassword($array[1]);
            self::setServerName($array[2]);
        }
    }

    public static function writeToFile()
    {
        $file = fopen(self::PATH,"w");
        fwrite($file,self::getUserName());
        fwrite($file,self::getPassword());
        fwrite($file,self::getServerName());
    }

}

?>