<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../conf/sesion.php';
require_once '../../conf/conf.php';
require_once '../../connection/conex.php';


if (isset($_POST["formSearch"]) && $_POST["formSearch"]){
    
    $admin = new admin();
    
    $values = array();
    parse_str($_POST['datosForm'], $values);
    
    $admin->listarPaquetes($values);
    
}


if (isset($_POST["formSearchRet"]) && $_POST["formSearchRet"]){
    
    $admin = new admin();
    
    $values = array();
    parse_str($_POST['datosForm'], $values);
    
    $admin->listarRetiros($values);
    
}


if ( isset($_POST["consultapaquete"]) && $_POST["consultapaquete"] ){
    
    $admin = new admin();
    
    $admin->consultapaquete($_POST);
    
}


if ( isset($_POST["consultaretiro"]) && $_POST["consultaretiro"] ){
    
    $admin = new admin();
    
    $admin->consultaretiro($_POST);
    
}

if ( isset($_POST["actualizarPaquete"]) && $_POST["actualizarPaquete"] ) {

    $admin = new admin();
    
    $values = array();
    parse_str($_POST['datosForm'], $values);
    //var_export($values);
    $admin->actualizarPaquete($values);
    
}

if ( isset($_POST["actualizarRetiro"]) && $_POST["actualizarRetiro"] ) {

    $admin = new admin();
    
    $values = array();
    parse_str($_POST['datosForm'], $values);
    
    $admin->actualizarRetiro($values);
    
}
















/********************************************************************/
//  Metodos de cliente...
/********************************************************************/

if ( isset($_POST["html"]) && file_exists($_POST["html"].".php") ) {
        include $_POST["html"].".php";
}

if (isset($_POST["login"]) && $_POST["login"]){
    
    $cliente = new cliente();
    
    $cliente->loguearse( [ "user_login" => $_POST["user_login"], "pass_login" => $_POST["pass_login"] ] );
    
}

if ( isset($_POST["logout"]) ) {
    session_destroy();
}

if ( isset($_POST["registro"]) && $_POST["registro"] ){
    
    
    $cliente = new cliente();
    
    $cliente->registrarCliente();
    
}

if ( isset($_POST["miperfil"]) && $_POST["miperfil"] ){
    
    $cliente = new cliente();
    
    $cliente->miPerfil();
    
}


if ( isset($_POST["aceptarCompra"]) && $_POST["aceptarCompra"] ){
    
    $cliente = new cliente();
    
    $cliente->aceptarCompra($_POST);
    
}

if ( isset($_POST["editarPerfil"]) && $_POST["editarPerfil"] ){
    
    $cliente = new cliente();
    $cliente->editarPerfil($_POST);
    
}

if ( isset($_POST["solicitarRetiro"]) && $_POST["solicitarRetiro"] ){
    
    $cliente = new cliente();
    
    $cliente->procesarRetiro($_POST["formaPago"]);
    
}


if ( isset($_POST["guardarCuentaBancaria"]) && $_POST["guardarCuentaBancaria"] ) {
    
    $cliente = new cliente();
    $cliente->guardarCuentaBancaria($_POST);
    
}