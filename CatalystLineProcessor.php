<?php

namespace Cataylst;

include_once('LineProcessor.php');
include_once('MYSQLHandler.php');
include_once('MYSQLTableDef.php');

use Cataylst\LineProcessor;
use Catalyst\MYSQLHandler;
use Catalyst\MYSQLTableDef;

/**
 * CatalystLineProcessor - implement interface lineprocessor to process each line of a file. CatalystLineProcessor is a tailor-made component for this task, 
 * to ensure:
 *  - Name and surname fields are capitalised, e.g. from “john” to “John” 
 *  - Emails are in lower case;
 *  - Email is valid
 */
class CatalystLineProcessor implements LineProcessor
{
    private int $mode = 0; //0 = Dry-run, 1 = Full-run  *PHP doesnt have ENUM
    private $MYSQLHandler;
    private $MYSQLTableDef;

    //constructor
    public function __construct($MYSQLHandler,$MYSQLTableDef)
    {
        $this->setMYSQLHandler($MYSQLHandler);
        $this->setMYSQLTableDef($MYSQLTableDef);
    }
    //check if all set
    public function allSet():bool
    {
        if(isset($this->MYSQLHandler) and isset($this->MYSQLTableDef))
        {
            return true;
        }else
        {
            return false;
        }
    }
    //setter
    public function setMYSQLTableDef(MYSQLTableDef $MYSQLTableDef)
    {
        $this->MYSQLTableDef = $MYSQLTableDef;
    }
    public function setMYSQLHandler(MYSQLHandler $MYSQLHandler)
    {
        $this->MYSQLHandler = $MYSQLHandler;
    }
    public function setMode(int $mode)
    {
        $this->mode = $mode;
    }

    /**
     * Implement processArray from Line processor, parse the data and insert record into database if it is not dry run
     * 
     * @param $array, array of data
     * @param $header, array of header
     */
    public function processArray(array $array, array $header = [])
    {
        if(filter_var($array[2], FILTER_VALIDATE_EMAIL) == false)    //if email is not valid
        {
            print('User ' . $array[0] . ' ' . $array[1] . ' hasn\'t been added to the database as the email ' . $array[2] . ' is not valid.' .PHP_EOL);
        }else
        {
            $array[0] = "'".ucfirst(strtolower($array[0]))."'";     //first item is name, needed to be capitalised
            $array[1] = "'".ucfirst(strtolower($array[1]))."'";     //second item is surname, needed to be capitalised
            $array[2] = "'".strtolower($array[2])."'";  //third item is email, needed to be in lower case
            
            if($this->mode == 1)    //for real
            {   
                $this->MYSQLHandler->InsertRecordFromArray($this->MYSQLTableDef->getDBName(),$this->MYSQLTableDef->getTableName(),$array,$this->MYSQLTableDef->getHeader());
            }
            
        }        
    }
}

?>