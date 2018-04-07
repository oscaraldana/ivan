<?php

class cliente {

    public $gananciasInversion;
    public $gananciasReferidos;
    public $gananciasTotales;
    public $gananciasPorPaquete;
    public $dispoParaRetiro;
    public $misRetiros;
    public $misRetirosPorPaquete;
    
    function __construct(){
        $this->gananciasInversion = 0;
        $this->gananciasReferidos = 0;
        $this->gananciasTotales = 0;
        $this->gananciasPorPaquete = [];
        $this->dispoParaRetiro = 0;
        $this->misRetiros = [];
        $this->misRetirosPorPaquete = [];
    }
    
    public function loguearse($data){
        
        $conex = WolfConex::conex();
        
        $sql = "select * from cliente where login = '".$data["user_login"]."' and contrasena = '". md5($data["pass_login"]) ."' and estado = 1 ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        $row = mysqli_fetch_array($result);
            
        //$result = $conex->Execute($sql);
        if ( !mysqli_num_rows($result) > 0 ){
            echo json_encode( ["respuesta" => false ] );
        } else {
            
            $_SESSION["clientId"] = $row["cliente_id"];
            $_SESSION["clientNombre"] = $row["nombre"];
            $_SESSION["clientLogin"] = $row["login"];
            
            echo json_encode( [ "respuesta" => true, "usuario" => $row["login"] ] );
        }
        
        
        return true;
    }
    
    public function registrarCliente ($datosForm) {
        
        $conex = WolfConex::conex();
        
        $sql = "select * from cliente where login = '".$datosForm["referido"]."' ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        $row = mysqli_fetch_array($result);
        
        if ( !mysqli_num_rows($result) > 0 ){
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "El referido ".$datosForm["referido"]." no se encuentra en nuestra base de datos" ] );
        } else {
            
            $ref = $row["cliente_id"];
            
            $sql = "select * from cliente where login = '".$datosForm["usuario"]."' ";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            if ( mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 2, "msg" => "El usuario ".$datosForm["usuario"]." ya existe en nuestro sistema." ] );
            } else {
                
                $sql = "insert into cliente (nombre, login, contrasena, correo, estado, referido) values ('".$datosForm["nombre"]."', '".$datosForm["usuario"]."', '".md5($datosForm["clave1"])."', '".$datosForm["mail"]."', 1, ".$ref.")";
                $result = mysqli_query($conex->getLinkConnect(), $sql);
                if ( !$result ) {
                    echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible registrar en este momento." ] );
                } else {
                    echo json_encode( ["respuesta" => true, "msg" => "Usuario registrado exitosamente." ] );
                }
            }
            
            
        }
        
    }
    
    
    public function miPerfil(){
        
        
        if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"]) ){
    
            $conex = WolfConex::conex();

            $sql = "select cliente.nombre, cliente.correo, cliente.login, c.login as referido
                    from cliente
                    inner join cliente c on c.cliente_id = cliente.referido
                    where cliente.cliente_id = ".$_SESSION["clientId"]." ";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Los datos d eusuario no se encuentran disponibles!" ] );
            } else {
                echo json_encode( ["respuesta" => true, "msg" => "Datos de perfil", "datos" => $row ] );
            }
        }
        
    }
    
    
    public function aceptarCompra ($param) {
        
        $conex = WolfConex::conex();
        
        $referencia = "";
        $tipop = "";
        
        if ( !empty($param["transBit"]) ) {
            $referencia = $param["transBit"];
            $tipo = "BITCOIN";
        } else {
            $referencia = $param["transBan"];
            $tipo = "BANCO";
        }
        
        $sql = "insert into paquetes_cliente ( paquete_id, cliente_id, estado, referencia_pago, tipo_pago ) values ( ".$param["paquete"].", ".$_SESSION["clientId"].", 0, '$referencia', '$tipo' )";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible registrar tu solicitud en este momento." ] );
        } else {
            echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, vamos a verificar la veracidad de tu compra." ] );
        }
        
    }
    
    
    
    public function editarPerfil ($datosForm) {
        
        $conex = WolfConex::conex();
        
        $sql = "update cliente set nombre = '".$datosForm["nombre"]."', correo = '".$datosForm["mail"]."' where cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible actualizar tu perfil en este momento." ] );
        } else {
            $_SESSION["clientNombre"] = $datosForm["nombre"];
            echo json_encode( ["respuesta" => true, "msg" => "Perfil actualizado exitosamente." ] );
        }

    }
    
    
    public function consultarPaquetes () {
     
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select * from paquetes";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            return false;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                return false;
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
                return $res;
            }
        }
        
    }
    
    
    public function consultarPaquetesCliente () {
     
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select paquetes_cliente.fecha_registro, paquetes.nombre as paquete, paquetes.valor as valor, paquetes_cliente.estado as estado, tipo_pago "
                . " from paquetes_cliente "
                . " inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id"
                . " where paquetes_cliente.cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            return false;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                return false;
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
                return $res;
            }
        }
        
    }
    
    
    
    public function consultarGanancias() {
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select * 
                    from paquetes_cliente 
                    inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id 
                    where paquetes_cliente.cliente_id = ".$_SESSION["clientId"]." and paquetes_cliente.estado = 1";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            return false;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                return false;
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
                
                //var_export($res);
                $dias = 0;
                foreach ($res as $k => $paq){
                    
                    $actualDate = date('Y-m-d'); // ." -> ".$paq["inicia"]." -> ".$paq["finaliza"];
                    //echo $actualDate." -> ".$paq["inicia"]." -> ".$paq["finaliza"]; // echos today! 
                    $initDate = date('Y-m-d', strtotime($paq["inicia"]));
                    $finishDate = date('Y-m-d', strtotime($paq["finaliza"]));

                    if ($actualDate >= $initDate && $actualDate <= $finishDate){
                        //echo "<hr>";
                        $fechaInicio=strtotime($paq["inicia"]);
                        $fechaFin=strtotime(date('Y-m-d'));
                        $m = ""; $d = 0;
                        for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                            if( $m != date("m", $i) ){
                                $m = date("m", $i);
                                $d=0;
                            }
                            
                            if( date("N", $i) < 6 ) {
                                $d++;
                                if($d<=20){
                                    $dias++;
                                }
                            }
                        }
                        
                      //echo "is between -> $meses -> $diasMeses<br>";
                    }
                    
                    $valorDia = ($paq["valor"] * ( $paq["rentabilidad"] / 100 ) ) / 20;
                    $this->gananciasInversion += ($valorDia * $dias);
                    
                    $this->gananciasPorPaquete[$k] = $paq;
                    $this->gananciasPorPaquete[$k]["ganancia"] = ($valorDia * $dias);
                }
                
            }
        }
        
        $this->gananciasTotales = $this->gananciasInversion + $this->gananciasReferidos;
        
    }
    
    
    public function consultarDatosParaRetiro() {
        
        $this->consultarGanancias();
        
        foreach ( $this->gananciasPorPaquete as $ganPaq ) {
            
            if ( $ganPaq["ganancia"] >= $ganPaq["retiro_minimo"] ) {
                $this->dispoParaRetiro += $ganPaq["ganancia"];
            }
            
        }
        
    }
    
    
    public function procesarRetiro($formaPago){
        
        $conex = WolfConex::conex();
        
        mysqli_autocommit($conex->getLinkConnect(), FALSE); // turn OFF auto
        
        $this->consultarDatosParaRetiro();
        $cuentas = $this->consultarMisCuentas();
        
        if ( $this->dispoParaRetiro > 0 ){
            
        
            $vlrComision = $this->dispoParaRetiro * ( COMISION_RETIRO / 100 );
            $vlrRetirar = $this->dispoParaRetiro - $vlrComision;
        

        
            if ( $formaPago == 1 ) {  // Bitcoin
                $bitcoin = $cuentas[0]["bitcoin"];
                $banco = "";
                $tipo = "";
                $cuenta = "";
                $titular = "";
            } else { // Banco
                $bitcoin = "";
                $banco = $cuentas[0]["banco"];
                $tipo = $cuentas[0]["tipo"];
                $cuenta = $cuentas[0]["cuenta"];
                $titular = $cuentas[0]["titular"];
            }

            $sql = "insert into retiros_cliente ( cliente_id, valor_retiro, valor_comision, valor_pagado, bitcoin, banco, cuenta, tipo_cuenta, titular, estado ) values "
                                                . "( ".$_SESSION["clientId"].", '".$this->dispoParaRetiro."', '".$vlrComision."', '".$vlrRetirar."', '".$bitcoin."', '".$banco."', '".$cuenta."', '".$tipo."', '".$titular."', 0 )";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            
            $exito = true;
            $retId = "";
            if ( !$result ) {
                $exito = false;
            } else {
                $retId = mysqli_insert_id($conex->getLinkConnect());
            }
            
            
            if ( !empty($retId) ) {
                
                foreach ( $this->gananciasPorPaquete as $ganPaq ) {
            
                    if ( $ganPaq["ganancia"] >= $ganPaq["retiro_minimo"] ) {
                        
                        $sql = " insert into retiros_paquetes (retiro_cliente_id, paquete_cliente_id, valor_retiro) values ($retId, ".$ganPaq["paquete_cliente_id"].", '".$ganPaq["ganancia"]."' ) ";
                        $result = mysqli_query($conex->getLinkConnect(), $sql);
                        if ( !$result ) {
                            $exito = false;
                            break;
                        }

                    }

                }
                
            }
            
            if ( !$exito ) {
                mysqli_commit($conex->getLinkConnect());
                echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible registrar tu solicitud en este momento." ] );
            } else {
                echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, pronto se hara efectivo tu retiro." ] );
            }
        }
        
        mysqli_autocommit($conex->getLinkConnect(), TRUE); // turn ON auto
    }
    

    public function consultarMisCuentas(){
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select * from cuenta_cliente where cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            return false;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                return false;
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
                return $res;
            }
        }
    }


    public function guardarCuentaBancaria( $dataForm ){
        
        $conex = WolfConex::conex();
        
        if ( isset($dataForm["idCuenta"]) && !empty($dataForm["idCuenta"]) ){
            $sql = "update cuenta_cliente set banco = '".$dataForm["banco"]."', cuenta = '".$dataForm["numeroCuenta"]."', titular = '".$dataForm["aNombre"]."', tipo = '".$dataForm["tipoCuenta"]."', bitcoin = '".$dataForm["cuentaBitcoin"]."' where cliente_id = ".$dataForm["idCuenta"]." ";
        } else {
            $sql = "insert into cuenta_cliente ( cliente_id, banco, cuenta, titular, tipo, bitcoin ) values ( ".$_SESSION["clientId"].", '".$dataForm["banco"]."', '".$dataForm["numeroCuenta"]."',  '".$dataForm["aNombre"]."',  '".$dataForm["tipoCuenta"]."',  '".$dataForm["cuentaBitcoin"]."' )";
        }
        
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible registrar tu solicitud en este momento." ] );
        } else {
            echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado exitosamente." ] );
        }
    }

    
    public function consultarRetiros () {
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select * from retiros_cliente where cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            $this->misRetiros = [];
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                $this->misRetiros = [];
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                    
                    $sql2 = "select * from retiros_paquetes where retiro_cliente_id = ".$fila["retiro_id"];
                    $result2 = mysqli_query($conex->getLinkConnect(), $sql2);
                    if ( !$result2 ) {
                        $this->misRetirosPorPaquete[$fila["retiro_id"]] = [];
                    } else {
                        if ( !mysqli_num_rows($result2) > 0 ){
                            $this->misRetirosPorPaquete[$fila["retiro_id"]] = [];
                        } else {
                            while ($fila2 = mysqli_fetch_array($result2)) {
                                $this->misRetirosPorPaquete[$fila["retiro_id"]][] = $fila2;
                            }
                        }
                    }
                    
                }
                $this->misRetiros = $res;
            }
        }
        
    }
    
    
    
    
    public function primerDiaMes() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
  }
    public function unMesAntes() {
      $month = date('m');
      $year = date('Y');
      $day = date('d');
      return date('Y-m-d', mktime(0,0,0, $month-1, $day, $year));
  }
}
