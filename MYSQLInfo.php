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

    //private $path = 'MYSQLInfo.txt';
    private $infoArray = [];

    /**
     * To determine if credential is all set
     */
    public function allSet():bool
    {
        if(isset($this->infoArray['serverName']) and isset($this->infoArray['userName']) and isset($this->infoArray['password']))
        {
            return true;
        }else{
            return false;
        }
    }
    /**
     * Bunch of getter setter
     */
    public function getServerName() : String {
        return $this->infoArray['serverName'];
    }

    public function getUserName() : String {
        return $this->infoArray['userName'];
    }

    public function getPassword() : String{
        return $this->infoArray['password'];
    }

    public function setServerName(String $serverName){
        $this->infoArray['serverName'] = $serverName;
    }

    public function setUserName(String $userName){
        $this->infoArray['userName'] = $userName;
    }

    public function setPassword(String $password){
        $this->infoArray['password'] = $password;
    }

    /*public function readFromFile()
    {
        if(file_exists($this->PATH))
        {
            $array = file($this->PATH);
            $this->setUserName($array[0]);
            $this->setPassword($array[1]);
            $this->setServerName($array[2]);
        }
    }

    public function writeToFile()
    {
        $file = fopen($this->PATH,"w");
        fwrite($file,$this->getUserName());
        fwrite($file,$this->getPassword());
        fwrite($file,$this->getServerName());
    }*/

}

?>