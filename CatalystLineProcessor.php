<?php

namespace Cataylst;

include_once('LineProcessor.php');
include_once('MYSQLHandler.php');

use Catalyst\MySQLRecordInserter;
use Cataylst\LineProcessor;
use Catalyst\MYSQLHandler;

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
    public function __construct($MYSQLHandler)
    {
        $this->setMYSQLHandler($MYSQLHandler);
    }
    
    public function setMYSQLHandler(MYSQLHandler $MYSQLHandler)
    {
        $this->MYSQLHandler = $MYSQLHandler;
    }

    public function setMode(int $mode)
    {
        $this->mode = $mode;
    }

    public function processArray(array $array, array $header = [])
    {
        $array[0] = ucfirst($array[0]);     //first item is name, needed to be capitalised
        $array[1] = ucfirst($array[1]);     //second item is surname, needed to be capitalised
        $array[2] = strtolower($array[2]);  //third item is email, needed to be in lower case

        if(filter_var($array[2], FILTER_VALIDATE_EMAIL) == false)    //if email is not valid
        {
            print('User ' . $array[0] . ' ' . $array[1] . ' hasn\' been added to the database as the email ' . $array[2] . ' is not valid.');
        }else
        {
            if($this->mode == 1)
            {   
                $this->MYSQLHandler->InsertRecordFromArray('users',$array,$header);
            }
        }

        var_dump($array);
        
    }
}

?>