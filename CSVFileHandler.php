<?php

namespace Catalyst;

include('LineProcessor.php');
use Cataylst\LineProcessor;

/**
 *  CSVFileHandler - implement FileHandler, to handle the CSVfile line by line. Each line will be processed by the processor.
 */
class CSVFileHandler{

    private LineProcessor $processor;   //contains method process to process each line of the file

    /*public function __construct($processor) {
        $this->processor = $processor;
    }*/

    /**
     * @param $path, the path of the file to be processed
     */
    public function processFileFromPath($path,$skipHeader = false)
    {
        $file = fopen($path,'r+') or die('Error: Cannot open ' . $path);
        $this->processFileByLine($file,$skipHeader);
    }

    /**
     * @param $file, the file to be processed
     */
    public function processFileByLine($file, $skipHeader = false)
    {
        if($skipHeader)
        {
            fgets($file);   //skip Header
        }
        while(!feof($file))
        {
            var_dump(fgetcsv($file));
            //$processor->process();
        }
    }
}

?>