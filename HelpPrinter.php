<?php
namespace Catalyst;

/**
 * To print the help
 */
class HelpPrinter{

    public static function printHelp()
    {
        $output =  
"
usage: user_upload.php [--file <path>] [--create_table] [--dry_run] [--help]
                       [-u <username>] [-p <password>] [-h <hostname>]

--file [csv file name] – this is the name of the CSV to be parsed;
--create_table – this will cause the MySQL users table to be built (and no further
  action will be taken);
--dry_run – this will be used with the --file directive in the instance that we want to run the
  script but not insert into the DB. All other functions will be executed, but the database won't
  be altered;
-u – MySQL username;
-p – MySQL password;
-h – MySQL host;
--help – which will output the above list of directives with details.

";
        fwrite(STDOUT, $output);
    }
}

?>