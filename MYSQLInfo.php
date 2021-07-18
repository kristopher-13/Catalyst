<?php

namespace Catalyst;

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

    public static function setServerName($serverName){
        self::$infoArray['serverName'] = $serverName;
    }

    public static function setUserName($userName){
        self::$infoArray['userName'] = $userName;
    }

    public static function setPassword($password){
        self::$infoArray['password'] = $password;
    }

    public static function readFromFile()
    {
        if(file_exists(self::PATH))
        {
            $array = file(self::PATH);
            setUserName($array[0]);
            setPassword($array[1]);
            setServerName($array[2]);
        }
    }

    public static function writeToFile()
    {
        $file = fopen(self::PATH,"w");
        fwrite($file,$this->getUserName());
        fwrite($file,$this->getPassword());
        fwrite($file,$this->getServerName());
    }

}

?>