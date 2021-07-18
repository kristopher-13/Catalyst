<?php
/**
 *  OptionHandler - served as a handler that calls functions according to the option
 */
namespace Catalyst;

include 'MYSQLInfo.php';
use Catalyst\MYSQLInfo;

class OptionsHandler{

    public const SHORTOPT ='u:p:h:';      //Accept short option -u, -p, -h
    
    public const LONGOPT = [
                        'file:',        //Accept long option --file, --create_table, --dry_run, --help 
                        'create_table',
                        'dry_run',
                        'help'
                    ];

    /**
     *  This function is to handle each options values pair and dispatch them to corresponding functions
     */
    public static function handleOptions()
    {
        $options = getopt(self::SHORTOPT,self::LONGOPT);  //Get Option

        //var_dump($options);
        foreach($options as $key => $value)     //handle each options
        {
            switch($key)
            {   
                case 'u':
                    MYSQLInfo::setUserName($value);
                    break;
                case 'p':
                    MYSQLInfo::setPassword($value);
                    break;
                case 'h':
                    MYSQLInfo::setHostName($value);
                    break;    
                case 'file':
                    break;
                case 'create_table':
                    break;
                case 'dry_run':
                    break; 
                case 'help':
                    break;
                default:
                    die('Error: Unexpected option');        //Supposedly there will be no any other options captured
                    break;         
            }
            var_dump(MYSQLInfo::$infoArray);
        }
    }

}

?>