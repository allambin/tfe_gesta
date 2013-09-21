<?php
namespace Maitrepylos;

 
class Debug
{
    public static function dump($var,$echo=true) {
 
 

        ob_start();
        var_dump($var);
        $output = ob_get_clean();
 

        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre>'
                . $output
                . '</pre>';
 
 
        if ($echo) {
            echo($output);
        }

    }
}