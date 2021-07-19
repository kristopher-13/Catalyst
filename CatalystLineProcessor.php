<?php

namespace Cataylst;

include('LineProcessor.php');
use Cataylst\LineProcessor;

/**
 * CatalystLineProcessor - implement interface lineprocessor to process each line of a file. CatalystLineProcessor is a tailor-made component for this task, 
 * to ensure:
 *  - Name and surname fields are capitalised, e.g. from “john” to “John” 
 *  - Emails are in lower case;
 */
class CatalystLineProcessor implements LineProcessor
{
    public function processArray(array $array)
    {
        $array[0] = ucfirst($array[0]);
        $array[1] = ucfirst($array[1]); 
        $array[2] = strtolower($array[2]);

        var_dump($array);
    }
}

?>