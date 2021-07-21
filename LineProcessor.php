<?php

namespace Cataylst;

/**
 * To specify the method for processing a line
 */
interface LineProcessor{
    public function processArray(array $array,array $header = []);
}

?>