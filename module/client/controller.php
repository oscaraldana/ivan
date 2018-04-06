<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../conf/sesion.php';
require_once '../../conf/conf.php';
require_once '../../connection/conex.php';

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
    
    $datosForm = [];
    parse_str($_POST["datosForm"], $datosForm);
    
    $cliente->registrarCliente($datosForm);
    
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
    
    $datosForm = [];
    parse_str($_POST["datosForm"], $datosForm);
    $cliente = new cliente();
    $cliente->editarPerfil($datosForm);
    
}

if ( isset($_POST["solicitarRetiro"]) && $_POST["solicitarRetiro"] ){
    
    $cliente = new cliente();
    
    $cliente->procesarRetiro($_POST["formaPago"]);
    
}


if ( isset($_POST["guardarCuentaBancaria"]) && $_POST["guardarCuentaBancaria"] ) {
    
    $cliente = new cliente();
    $cliente->guardarCuentaBancaria($_POST);
    
}