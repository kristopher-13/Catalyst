<?php
/**
 *  OptionHandler - served as a handler that calls functions according to the option
 */
namespace Catalyst;

include_once('MYSQLInfo.php');
include_once('HelpPrinter.php');
include_once('CSVFileHandler.php');
include_once('CatalystLineProcessor.php');

use Cataylst\CatalystLineProcessor;
use Catalyst\MYSQLInfo;
use Catalyst\HelpPrinter;
use Catalyst\CSVFileHandler;
use \Exception;
class OptionsHandler{

    //WARNING: The order does matter as getOption will based on the order to create the array. file should be processed before create_table and dry_run
    public const SHORTOPT ='u:p:h:';      //Accept short option -u, -p, -h
    
    public const LONGOPT = [
                        'file:',        //Accept long option --file, --create_table, --dry_run, --help 
                        'create_table',
                        'dry_run',
                        'help',
                    ];
    
    public const DBNAME = 'Catalyst';
    public const TABLENAME = 'users';
    public const TABLEDEF = [
        'name' => 'VARCHAR(256) NOT NULL',
        'surname' => 'VARCHAR(256) NOT NULL',
        'email' => 'VARCHAR(256) PRIMARY KEY',
    ];                

    /**
     *  This function is to handle each options values pair and dispatch them to corresponding functions
     */
    public static function handleOptions()
    {
        $options = getopt(self::SHORTOPT,self::LONGOPT);  //Get Option

        //Initalize
        $CSVFileHandler = new CSVFileHandler();
        $MYSQLHandler = new MYSQLHandler();
        $MYSQLInfo = new MYSQLInfo();
        
        $MYSQLTableDef = new MYSQLTableDef();
        $MYSQLTableDef->setDBName(self::DBNAME);
        $MYSQLTableDef->setTableName(self::TABLENAME);
        $MYSQLTableDef->setFieldDef(self::TABLEDEF);

        $CatalystLineProcessor = new CatalystLineProcessor($MYSQLHandler,$MYSQLTableDef);

        $run = true;
        try{
            foreach($options as $key => $value)     //handle each options
            {
                switch($key)
                {   
                    //set credential
                    case 'u':
                        $MYSQLInfo->setUserName($value);
                        break;

                    case 'p':
                        $MYSQLInfo->setPassword($value);
                        break;

                    case 'h':
                        $MYSQLInfo->setServerName($value);
                        break;  

                    case 'file':
                        $CSVFileHandler->load($value);
                        break;

                    case 'create_table':
                        $run = false;    //No more further action taken   *dry run can still be executed
                        if($MYSQLInfo->allSet())
                        {
                            $MYSQLHandler->setMYSQLInfo($MYSQLInfo);
                            if($CSVFileHandler->loaded()) //if file path is entered
                            {
                                $MYSQLHandler->createTableFromArray($MYSQLTableDef->getDBName(),$MYSQLTableDef->getTableName(),$MYSQLTableDef->getFieldDef(),true);
                            }
                            else{
                                throw new Exception('File path is not entered');
                            }
                        }else
                        {
                            throw new Exception('Database crediential are not all set');
                        }        
                        break;

                    case 'dry_run':
                        $run = false;   //database should not be altered
                        if($CSVFileHandler->loaded())
                        {
                            $CSVFileHandler->processFileByLine(true,$CatalystLineProcessor);
                        }else
                        {
                            throw new Exception('File path is not entered');
                        }
                        break; 

                    case 'help':
                        HelpPrinter::printHelp();
                        break;

                    default:
                         throw new Exception('Unexpected Option');        //Supposedly there will be no any other options captured
                        break;         
                }  
            }//var_dump($options);
            if($run)
            {
                if($MYSQLInfo->allSet() and $CSVFileHandler->loaded())    //real run
                {
                    $MYSQLHandler->setMYSQLInfo($MYSQLInfo);    
                    $CatalystLineProcessor->setMode(1); //for real
                    $CSVFileHandler->processFileByLine(true,$CatalystLineProcessor);
                }else{
                    throw new Exception('File path is not entered or Database crediential are not all set');  
                }
            }
        }catch(Exception $e) {
            echo $e->getMessage();
        }   
    }

}

?>