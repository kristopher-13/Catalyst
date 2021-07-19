<?php

namespace Catalyst;

use Cataylst\LineProcessor;

/**
 *  CSVFileHandler - implement FileHandler, to handle the CSVfile line by line. Each line will be processed by the processor.
 */
class CSVFileHandler{

    /*public function __construct($processor) {
        $this->processor = $processor;
    }*/

    /**
     * @param $path, the path of the file to be processed
     */
    public function processFileFromPath($path, $skipHeader = false, LineProcessor $processor)
    {
        $file = fopen($path,'r+') or die('Error: Cannot open ' . $path);
        $this->processFileByLine($file,$skipHeader, $processor);
    }

    /**
     * @param $file, the file to be processed
     */
    public function processFileByLine($file, bool $skipHeader = false, LineProcessor $processor)
    {
        if($skipHeader)
        {
            fgets($file);   //skip Header
        }
        while(!feof($file))
        {
            if($array = fgetcsv($file)) //To avoid EOF bool false
            {
                //vardump($array);
                $processor->processArray($array);
            }
            
        }
    }
}

?>