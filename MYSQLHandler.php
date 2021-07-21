<?php
namespace Catalyst;

include_once('MySQLInfo.php');

use mysqli;
use \Exception;
use Catalyst\MYSQLInfo;

/**
 * MYSQLHandler - this class is to handle every action related to the mysql database
 */
class MYSQLHandler{
 
    private MYSQLInfo $MYSQLInfo;   //username, password and hostname is stored in this object

    public function setMYSQLInfo(MYSQLInfo $MYSQLInfo)  //setter
    {
        $this->MYSQLInfo = $MYSQLInfo;
    }

    /**
     * Check if MYSQLInfo is set
     */
    public function hasMYSQLInfo():bool{    
        if(isset($this->MYSQLInfo))
        {
            return true;
        }else
        {
            return false;
        }
    }

    /**
     * Create database
     */
    public function createDB(string $dbName, mysqli $conn = null){ 
        try{
            if(!isset($conn))
            {
                $conn = $this->getConnection();
            }
            if(mysqli_query($conn,'CREATE DATABASE IF NOT EXISTS '. $dbName .';'))
            {

            }else
            {
                throw new Exception('Error: Database' . $dbName .' cannot be created'); 
            }
            if(!isset($conn))
            {
                mysqli_close($conn);
            } 
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Connect to the database using MYSQLInfo
     * 
     * @return mysqli
     */
    public function getConnection() : mysqli {  
        try{
            $conn = mysqli_connect($this->MYSQLInfo->getServerName(), $this->MYSQLInfo->getUserName(), $this->MYSQLInfo->getPassword());
            if (!$conn) {
                throw new Exception("Error: " . mysqli_connect_error());
            }else{
                return $conn;
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Create a table in the database 
     * 
     * @param $tableName - table name
     * @param $array - array of header name
     * @param $replace - determine if the existing table to be replaced
     */
    public function createTableFromArray(string $dbName, string $tableName,array $fieldDef, bool $replace)
    {   
        
        $conn = $this->getConnection();
        
        $this->createDB($dbName, $conn);   //create database if not exist
        
        mysqli_select_db($conn, $dbName);   //use database
        
        if($replace)    //remove existing table if replace = true
        {
            $sql = 'TRUNCATE ' . $tableName;
            mysqli_query($conn, $sql);
        }

        $sql = 'CREATE TABLE '. $tableName . '(';

        $first = true;
        foreach($fieldDef as $fieldName => $option) //loop though all the fields with its option
        {
            if(!$first)
            {
                $sql .= ',';
            }else
            {
                $first = false;
            }

            $sql = $sql . $fieldName . ' '. $option;
        }
        $sql = $sql . ');';

        if(mysqli_query($conn, $sql))
        {
            print('Table ' . $tableName . ' has been created successfully' . PHP_EOL);
        }else
        {
            throw new Exception('Error: SQL '. $sql .' run failed');   
        } 
        mysqli_close($conn);
    }

    /**
     * Insert record to existing table
     * 
     * @param $tableName - table name
     * @param $array - array of data
     * @param $header - array of header name
     */
    public function InsertRecordFromArray(string $dbName, string $tableName,array $array,array $header)
    {
        $conn = $this->getConnection();

        $this->createDB($dbName, $conn);   //create databas if not exist

        mysqli_select_db($conn, $dbName);     //use database
        try{ 
            if(sizeof($array) == sizeof($header))
            {
                if(mysqli_query($conn,'Select 1 From '. $tableName . ' LIMIT 1'))   //if table exist
                {
                    $sql = 'INSERT INTO '. $tableName . '(' . implode(',',$header) . ')VALUES(' . implode(',',$array) . ')';
                    if(mysqli_query($conn, $sql))
                    {
                        'Record has been inserted successfully';
                    }else
                    {
                        throw new Exception('Error: SQL '. $sql .' run failed');
                    }

                    mysqli_close($conn);
                }else
                {
                    throw new Exception('Error: Table doesnt exist, No record is inserted in the database');
                }
            }
            else
            {
                throw new Exception('Error: Number of header is not the same as number of field');
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }

        
    }
    
}

?>