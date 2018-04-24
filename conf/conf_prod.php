<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once "../../autoload/clases.php";

define("USER_DB", "dbo730094761");
define("PASWD_DB", "L@cambie1");
define("HOST_DB", "db730094761.db.1and1.com");
define("PORT_DB", "3306");
define("NAME_DB", "db730094761");

define("PAGINA_ESTATICA_REDIRECCION_ERROR_BD", "../error_db.php");

define ( "COMISION_RETIRO", 5 );



if(isset($_SESSION['lang'])){
    // si es true, se crea el require y la variable lang
    $lang = $_SESSION["lang"];
    require_once '../../lang/'.$lang.".php";
    // si no hay sesion por default se carga el lenguaje espanol
}else{
	require "../../lang/es.php";
}