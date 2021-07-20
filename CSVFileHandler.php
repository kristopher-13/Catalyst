<?php

namespace Catalyst;

use Cataylst\LineProcessor;

/**
 *  CSVFileHandler - implement FileHandler, to handle the CSVfile line by line. Each line will be processed by the processor.
 */
class CSVFileHandler{

    private string $path;
    private array $header;
    private bool $hasHader = false;
    
    /**
     * To extract some meta-data from the file
     */
    public function load(string $path,bool $hasHeader)
    {
        $this->path = $path;
        if($hasHeader)
        {
            $this->hasHeader = $hasHeader;
            $this->header = $this->getHeader();
        }
    }

    /**
     * If a file is loaded
     */
    public function loaded():bool{
        
        if(isset($this->path) and $this->path != '')
        {
            return true;
        }else
        {
            return false;
        }
    }

    /**
     * @param $skipHeader, determine if the header should be processed
     * @param $processor, an object to process the line
     */
    public function processFileByLine(bool $skipHeader = false, LineProcessor $processor)
    {
        $file = fopen($this->path,'r+') or die('Error: Cannot open ' . $this->path);

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
        fclose($file);
    }

    /**
     * Extract header(first line) from the file
     */
    public function getHeader():array
    {
        $file = fopen($this->path,'r+') or die('Error: Cannot open ' . $this->path);
        $array = fgetcsv($file);
        fclose($file);
        return $array;
    }
}

?>