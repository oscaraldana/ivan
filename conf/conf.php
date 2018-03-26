<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../autoload/clases.php';

define("USER_DB", "root");
define("PASWD_DB", "root");
define("HOST_DB", "localhost");
define("PORT_DB", "3306");
define("NAME_DB", "wolves");

define("PAGINA_ESTATICA_REDIRECCION_ERROR_BD", "error_db.php");




if(isset($_SESSION['lang'])){
    // si es true, se crea el require y la variable lang
    $lang = $_SESSION["lang"];
    require_once '../lang/'.$lang.".php";
    // si no hay sesion por default se carga el lenguaje espanol
}else{
	require "../lang/es.php";
}