<?php
namespace Catalyst;

include_once('MySQLInfo.php');
use mysqli;
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
     * Connect to the database using MYSQLInfo
     * 
     * @return mysqli
     */
    public function getConnection() : mysqli {  
        $conn = mysqli_connect($this->MYSQLInfo->getServerName(), $this->MYSQLInfo->getUserName(), $this->MYSQLInfo->getPassword());
        if (!$conn) {
            die("Error: " . mysqli_connect_error());
        }else{
            return $conn;
        }
    }

    /**
     * Create a table in the database 
     * 
     * @param $tableName - table name
     * @param $array - array of header name
     * @param $replace - determine if the existing table to be replaced
     */
    public function createTableFromArray(String $tableName,array $array, bool $replace)
    {   
        $conn = $this->getConnection();

        if($replace)
        {
            $sql = 'TRUNCATE ' . $tableName;
            mysqli_query($this->conn, $sql);
        }

        $sql = 'CREATE TABLE '. $tableName . '(';
        foreach($array as $fieldName => $option)
        {
            $sql = $sql . $tableName . ' '. $option . ',';
        }
        $sql = $sql . ');';
        mysqli_query($this->$conn, $sql);
        mysqli_close($conn);
    }

    /**
     * Insert record to existing table
     * 
     * @param $tableName - table name
     * @param $array - array of data
     * @param $header - array of header name
     */
    public function InsertRecordFromArray(String $tableName,array $array,array $header)
    {
        $conn = $this->getConnection();

        if(sizeof($array) == sizeof($header))
        {
            if(mysqli_query($conn,'Select 1 From '. $tableName . ' LIMIT 1'))   //if table exist
            {
                $sql = 'INSERT INTO '. $tableName . '(' . implode(',',$header) . ')VALUES(' . implode(',',$array) . ')';
                mysqli_query($this->$conn, $sql);
                mysqli_close($conn);
            }else
            {
                print('Error: Table doesnt exist, No record is inserted in the database');
            }
        }
        else
        {
            print('Error: Number of header is not the same as number of field');
        }

        
    }
    
}

?>