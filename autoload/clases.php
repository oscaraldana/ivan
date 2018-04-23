<?php

global $PathFile;
if(!isset($PathFile)) $PathFile="../";
$root = (dirname(__FILE__));
//require_once($root."/fun/fun_grales.php");
//require_once($root."/fun/fun_php.php");


spl_autoload_register('autoload_clases');                     

function autoload_clases($className)
{
    global $PathFile;
    $nombre = "";
    
    $nombre=$className;
    
    $fileName  = $PathFile."../class/".$nombre.".php";
    //error_log($fileName);
    if ( is_file($fileName) ){
         require $fileName;
    }else{
             $parts = explode('\\', $className);
             $fileName  = $PathFile; 
             for ($i = 0; $i < count($parts) - 1; $i++){
                 $fileName .= $parts[$i] . '/';
             }
             $fileName .= $parts[$i] . ".php";
             if ( is_file($fileName) ){
                 require_once $fileName;
             }else{
                $parts = explode('\\', $className);
                $fileName  = $PathFile."class/".end($parts).".php";
                if ( is_file($fileName) ){
                    require_once $fileName;
                }
            }
        }
    
 
}

