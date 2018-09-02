<?php

class cliente {

    public $gananciasInversion;
    public $gananciasReferidos;
    public $gananciasTotales;
    public $gananciasPorPaquete;
    public $dispoParaRetiro;
    public $misRetiros;
    public $misRetirosPorPaquete;
    public $misReferidos;
    public $imprimirMisRef;
    public $valorPendientePorReferidos;
    public $totales;
    
    function __construct(){
        $this->gananciasInversion = 0;
        $this->gananciasReferidos = 0;
        $this->gananciasTotales = 0;
        $this->gananciasPorPaquete = [];
        $this->dispoParaRetiro = 0;
        $this->misRetiros = [];
        $this->misRetirosPorPaquete = [];
        $this->misReferidos = [];
        $this->imprimirMisRef = "";
        $this->valorPendientePorReferidos = 0;
        $this->totales = [];
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
            $_SESSION["clientImg"] = $row["foto"];
            if ( $row["es_admin"] ){
                $_SESSION["clientIsAdmin"] = $row["es_admin"];
            }
            
            echo json_encode( [ "respuesta" => true, "usuario" => $row["login"] ] );
        }
        
        
        return true;
    }
    
    public function registrarCliente () {
        
        $datosForm = $_POST;
        $conex = WolfConex::conex();
        //var_export($_POST);
        if ( $_POST["clave1"] != $_POST["clave2"] ) {
            echo "<script>parent.sweetal(\"Las claves ingresadas no coinciden.\");</script>";
            return;
        }
        if ( $_POST["aceptoterminos"] != "1" ) {
            echo "<script>parent.sweetal(\"Para continuar, deberá aceptar los términos y condiciones.\");</script>";
            return;
        }
        
        $ref = "null";
        
        if ( !empty($datosForm["referido"]) ) {
            $sql = "select * from cliente where login = '".$datosForm["referido"]."' ";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            if ( !mysqli_num_rows($result) > 0 ){
                echo "<script>parent.sweetal(\"El referido ".$datosForm["referido"]." no se encuentra en nuestra base de datos.\");</script>";
                return;
                //echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "El referido ".$datosForm["referido"]." no se encuentra en nuestra base de datos" ] );
            } 
            $ref = $row["cliente_id"];
        }
        
        
            
        

        $sql = "select * from cliente where login = '".$datosForm["usuario"]."' ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        $row = mysqli_fetch_array($result);

        if ( mysqli_num_rows($result) > 0 ){
            echo "<script>parent.sweetal(\"El usuario ".$datosForm["usuario"]." ya existe en nuestro sistema.\");</script>";
            //echo json_encode( ["respuesta" => false, "error" => 2, "msg" => "El usuario ".$datosForm["usuario"]." ya existe en nuestro sistema." ] );
        } else {
            $dir = __DIR__."/../module/client/img/clients/";




            //var_export($_FILES);

            $sql = "insert into cliente (nombre, login, contrasena, correo, estado, referido) values ('".$datosForm["nombre"]."', '".$datosForm["usuario"]."', '".md5($datosForm["clave1"])."', '".$datosForm["mail"]."', 1, ".$ref.")";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            if ( !$result ) {
                    echo "<script>parent.sweetal(\"No es posible realizar el registro en este momento.\");</script>";
                //echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible registrar en este momento." ] );
            } else {

                $clientId = mysqli_insert_id($conex->getLinkConnect());

                if (isset($_FILES['foto']['tmp_name'])) {
                    $extencion = end(explode(".", $_FILES['foto']['name']));
                    if (!copy($_FILES['foto']['tmp_name'], $dir.$clientId.".".$extencion)){
                        error_log("Error al guardar la imagen");
                    }

                    $sql = " update cliente set foto = '".$clientId.".$extencion' where cliente_id = $clientId ";
                    $result = mysqli_query($conex->getLinkConnect(), $sql);
               }
               echo "<script>parent.sweetal(\"El registro se ha realizado exitosamente.\"); parent.closeModal();</script>";
                //echo json_encode( ["respuesta" => true, "msg" => "Usuario registrado exitosamente." ] );
            }


        }
            
            
        
        
    }
    
    
    public function cambiarUsuario(){
        
        if ( (isset($_POST["idUsuario"]) && !empty($_POST["idUsuario"])) && ( isset($_SESSION["clientIsAdmin"]) && $_SESSION["clientIsAdmin"] ) ) {
        
            $conex = WolfConex::conex();

            $sql = "select * from cliente where cliente_id = '".$_POST["idUsuario"]."'";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            //$result = $conex->Execute($sql);
            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false ] );
            } else {

                unset($_SESSION["clientIsAdmin"]);
                $_SESSION["clientId"] = $row["cliente_id"];
                $_SESSION["clientNombre"] = $row["nombre"];
                $_SESSION["clientLogin"] = $row["login"];
                $_SESSION["clientImg"] = $row["foto"];
                if ( $row["es_admin"] ){
                    $_SESSION["clientIsAdmin"] = $row["es_admin"];
                }

                echo json_encode( [ "respuesta" => true, "usuario" => $row["login"] ] );
            }
        } else {
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "No es posible realizar tu solicitud en este momento!" ] );
        }
        
        
    }
    
    public function miPerfil(){
        
        
        if(isset($_SESSION["clientId"]) && !empty($_SESSION["clientId"]) ){
    
            $conex = WolfConex::conex();

            $cond = $cond2 ='';
            
            if ( $_SESSION["clientId"] != "1" ){
                $cond = "inner join cliente c on c.cliente_id = cliente.referido";
                $cond2 = ", c.login as referido";
            }
            
            $sql = "select cliente.nombre, cliente.correo, cliente.login $cond2
                    from cliente
                    $cond
                    where cliente.cliente_id = ".$_SESSION["clientId"]." ";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Los datos de usuario no se encuentran disponibles!" ] );
            } else {
                echo json_encode( ["respuesta" => true, "msg" => "Datos de perfil", "datos" => $row ] );
            }
        }
        
    }
    
    
    public function aceptarCompra ($param) {
        
        $conex = WolfConex::conex();
        
        $cliente = $this->consultarCliente();
        $paq = $this->consultarPaquete($param["paquete"]);
        
        $referencia = "";
        $tipop = "";
        
        if ( !empty($param["transBit"]) ) {
            $referencia = $param["transBit"];
            $tipo = "BITCOIN";
        } else if ( !empty($param["transBit"]) ) {
            $referencia = $param["transBan"];
            $tipo = "BANCO";
        } else {
            if($param["opcionReinvertir"] == "1") {
                $referencia = "Ganancias Paquetes";
                $tipo = "RE INVERSION";
            }
            if($param["opcionReinvertir"] == "2") {
                $referencia = "Ganancias Referidos";
                $tipo = "RE INVERSION";
            }
            if($param["opcionReinvertir"] == "3") {
                $referencia = "Ganancias Paquetes y Referidos";
                $tipo = "RE INVERSION";
            }
            
        }
        
        $sql = "insert into paquetes_cliente ( paquete_id, cliente_id, estado, referencia_pago, tipo_pago ) values ( ".$param["paquete"].", ".$_SESSION["clientId"].", 0, '$referencia', '$tipo' )";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible registrar tu solicitud en este momento." ] );
        } else {
            if ( isset($param["opcionReinvertir"]) && $param["opcionReinvertir"] > 0 ) {
                $admin = new admin();
                $admin->aprobarReinversion($param, mysqli_insert_id($conex->getLinkConnect()));
            } else {
                echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, vamos a verificar la veracidad de tu compra." ] );
                $mail = new mailWTC();
                $paramsMail = [];
                $paramsMail["to"] = CORREO_ADMIN;
                $paramsMail["subject"] = "Compra de paquete";
                $paramsMail["messageTitle"] = "Compra de paquete ".$paq["nombre"]."";
                $paramsMail["messageBody"] = "El cliente ".$cliente[0]["nombre"]." genero una transaccion de compra de un paquete ".$paq[0]["nombre"]." por medio de $tipo. ";
                $mail->enviarMail($paramsMail);
            }
        }
        
    }
    
    
    
    public function editarPerfil ($datosForm) {
        
        $conex = WolfConex::conex();
        
        $sql = "update cliente set nombre = '".$datosForm["nombre"]."', correo = '".$datosForm["mail"]."' where cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo "<script>parent.sweetal(\"No es posible actualizar tu perfil en este momento.\");</script>";
            //echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible actualizar tu perfil en este momento." ] );
        } else {
            $_SESSION["clientNombre"] = $datosForm["nombre"];
            
            $fileInfo = "";
            
            if (isset($_FILES['foto']['tmp_name']) && !empty($_FILES['foto']['tmp_name'])) {
                $dir = __DIR__."/../module/client/img/clients/";
                $clientId = $_SESSION["clientId"];
                $extencion = end(explode(".", $_FILES['foto']['name']));
                if (!copy($_FILES['foto']['tmp_name'], $dir.$clientId.".".$extencion)){
                    error_log("Error al guardar la imagen");
                }

                $sql = " update cliente set foto = '".$clientId.".$extencion' where cliente_id = $clientId ";
                $result = mysqli_query($conex->getLinkConnect(), $sql);
                
                $fileInfo = "img/clients/".$clientId.".$extencion";
            }
            
            echo "<script>
                    parent.actInfo('".$datosForm["nombre"]."', '$fileInfo');
                    parent.sweetal(\"Perfil actualizado exitosamente.\");
                    parent.closeModalx('modalClient');
                  </script>";
            //echo json_encode( ["respuesta" => true, "msg" => "Perfil actualizado exitosamente." ] );
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
    
    
    public function consultarPaquetesCliente ( $params =[] ) {
     
        $orden = "";
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        if ( isset( $params["order"] ) ) {
            $orden = " order by ".$params["order"]." ";
        }
        
        $sql = "select paquetes_cliente.fecha_registro, paquetes.nombre as paquete, paquetes.valor as valor, paquetes_cliente.estado as estado, tipo_pago "
                . " from paquetes_cliente "
                . " inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id"
                . " where paquetes_cliente.cliente_id = ".$_SESSION["clientId"]
                . " $orden ";
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
                    where paquetes_cliente.cliente_id = ".$_SESSION["clientId"]." and paquetes_cliente.estado = 1"
                . " order by paquetes_cliente.finaliza desc ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
           
            while ($fila = mysqli_fetch_array($result)) {
                $res[] = $fila;
            }

            //var_export($res);
            $dias = 0;
            foreach ($res as $k => $paq){
                $dias = 0;
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
        
        $this->gananciasReferidos = 0;
        $sql = "SELECT bonos_referidos.*, cliente.referido 
                FROM bonos_referidos 
                inner join paquetes_cliente on paquetes_cliente.paquete_cliente_id = bonos_referidos.paquete_cliente_id 
                inner join cliente on cliente.cliente_id = paquetes_cliente.cliente_id 
                where cliente.referido = ".$_SESSION["clientId"]."";
        
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
           
            while ($fila = mysqli_fetch_array($result)) {
                
                if ( $fila["estado"] == "0" ){
                    $this->gananciasReferidos += $fila["valor"];
                }
                
            }

        }
        
        $sql = "SELECT * 
                FROM retiros_cliente
                WHERE cliente_id = ".$_SESSION["clientId"]." 
                 AND estado = 1 and tipo_retiro=2";
        
        
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
           
            while ($fila = mysqli_fetch_array($result)) {
                $this->gananciasReferidos -= $fila["valor_retiro"];
            }

        }
        
        $this->gananciasTotales = $this->gananciasInversion + $this->gananciasReferidos;
        
    }
    
    
    public function consultarDatosParaRetiro($validarMinimo = true) {
        
        $this->consultarGanancias();
        $this->consultarRetiros();
        //echo "<pre>"; var_Export($this->gananciasPorPaquete);
        //echo "<hr>";
        //var_export($this->misRetiros);
        //echo "<hr>";
        //var_export($this->misRetirosPorPaquete);
        //echo "</pre>";
        foreach ( $this->gananciasPorPaquete as $ganPaq ) {
            
            $retiroRestar = 0;
            if ( !$validarMinimo || ($validarMinimo && $ganPaq["ganancia"] >= $ganPaq["retiro_minimo"]) ) {
                
                foreach ( $this->misRetiros as $kRetp => $misRetPaq) {
                    if ( isset($misRetPaq["paquetes"]) && is_array($misRetPaq["paquetes"]) ){
                        foreach ( $misRetPaq["paquetes"] as $mrp ){
                            if ( $mrp["paquete_cliente_id"] == $ganPaq["paquete_cliente_id"] && $misRetPaq["estado"] == 1 ){
                                $retiroRestar += $mrp["valor_retiro"];
                            }
                        }
                    }
                }
                
                $valorDispoPaq = $ganPaq["ganancia"] - $retiroRestar;
                if ( $validarMinimo ) {
                    if ( $valorDispoPaq >= $ganPaq["retiro_minimo"] ) {
                        $this->dispoParaRetiro += $valorDispoPaq;
                    }
                } else {
                     $this->dispoParaRetiro += $valorDispoPaq;
                }
                
            }
            
        }
        
    }
    
    public function consultarDatosParaRetiroReferidos () {
        
        $conex = WolfConex::conex();
        //echo $_SESSION["clientId"]."<br>";
        //echo $_SESSION["clientId"];
        $sql = "SELECT bonos_referidos.*, cliente.referido 
                FROM bonos_referidos
                inner join paquetes_cliente on paquetes_cliente.paquete_cliente_id = bonos_referidos.paquete_cliente_id
                inner join cliente on cliente.cliente_id = paquetes_cliente.cliente_id
                where cliente.referido = ".$_SESSION["clientId"];
        
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        
        $res = [];
        if ( $result && mysqli_num_rows($result) > 0 ) {
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
        }
                
        $this->valorPendientePorReferidos = 0;
        foreach ( $res as $bonos ){
            if ( $bonos["estado"] == "0" ) {
                $this->valorPendientePorReferidos +=  $bonos["valor"];
            }
        }
        
        $sql = "SELECT * 
                FROM retiros_cliente
                WHERE cliente_id = ".$_SESSION["clientId"]." 
                 AND estado = 1 and tipo_retiro=2";
        
        
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
           
            while ($fila = mysqli_fetch_array($result)) {
                $this->valorPendientePorReferidos -= $fila["valor_retiro"];
            }

        }
        
    }
    
    
    public function procesarRetiro($formaPago, $tipoPago){
        
        $conex = WolfConex::conex();
        
        mysqli_autocommit($conex->getLinkConnect(), FALSE); // turn OFF auto
        
        
        $cuentas = $this->consultarMisCuentas();
        $cliente = $this->consultarCliente();
        
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
        
        // Por inversion
        if ( $tipoPago == "1" ){
            
            $this->consultarDatosParaRetiro();
            
            if ( $this->dispoParaRetiro > 0 ){


                $vlrComision = $this->dispoParaRetiro * ( COMISION_RETIRO / 100 );
                $vlrRetirar = $this->dispoParaRetiro - $vlrComision;

                $sql = "insert into retiros_cliente ( cliente_id, valor_retiro, valor_comision, valor_pagado, bitcoin, banco, cuenta, tipo_cuenta, titular, estado, tipo_retiro ) values "
                                                    . "( ".$_SESSION["clientId"].", '".$this->dispoParaRetiro."', '".$vlrComision."', '".$vlrRetirar."', '".$bitcoin."', '".$banco."', '".$cuenta."', '".$tipo."', '".$titular."', 0, '".$tipoPago."' )";
                $result = mysqli_query($conex->getLinkConnect(), $sql);

                $exito = true;
                $retId = "";
                if ( !$result ) {
                    $exito = false;
                } else {
                    $retId = mysqli_insert_id($conex->getLinkConnect());
                }


                if ( !empty($retId) && $tipoPago == "1" ) {

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
                    echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "No es posible registrar tu solicitud en este momento." ] );
                } else {
                    echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, pronto se hara efectivo tu retiro." ] );
                    $mail = new mailWTC();
                    $paramsMail = [];
                    $paramsMail["to"] = CORREO_ADMIN;
                    $paramsMail["subject"] = "Solicitud de retiro";
                    $paramsMail["messageTitle"] = "Solicitud de retiro - (US$ ".$ganPaq["ganancia"].")";
                    $paramsMail["messageBody"] = "El cliente ".$cliente[0]["nombre"]." ha solicitado un retiro de ganancias por inversion de  US$ ".$ganPaq["ganancia"].". ";
                    $mail->enviarMail($paramsMail);
                }
            }
        } else if ( $tipoPago == "2" ) { // Por Referidos
            
            $exito = true;
            $this->consultarDatosParaRetiroReferidos();
            
            if ( $this->valorPendientePorReferidos > 0 ) {
            
                $vlrComision = $this->valorPendientePorReferidos * ( COMISION_RETIRO / 100 );
                $vlrRetirar = $this->valorPendientePorReferidos - $vlrComision;
                
                $sql = "insert into retiros_cliente ( cliente_id, valor_retiro, valor_comision, valor_pagado, bitcoin, banco, cuenta, tipo_cuenta, titular, estado, tipo_retiro ) values "
                                                        . "( ".$_SESSION["clientId"].", '".$this->valorPendientePorReferidos."', '".$vlrComision."', '".$vlrRetirar."', '".$bitcoin."', '".$banco."', '".$cuenta."', '".$tipo."', '".$titular."', 0, '".$tipoPago."' )";
                $result = mysqli_query($conex->getLinkConnect(), $sql);
                
                $exito = true;
                $retId = "";
                if ( !$result ) {
                    $exito = false;
                } else {
                    $retId = mysqli_insert_id($conex->getLinkConnect());
                }

            }
            
            
            
            
            if ( !$exito ) {
                mysqli_commit($conex->getLinkConnect());
                echo json_encode( ["respuesta" => false, "error" => 2, "msg" => "No es posible registrar tu solicitud en este momento." ] );
            } else {
                echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, pronto se hara efectivo tu retiro." ] );
                $mail = new mailWTC();
                $paramsMail = [];
                $paramsMail["to"] = CORREO_ADMIN;
                $paramsMail["subject"] = "Solicitud de retiro";
                $paramsMail["messageTitle"] = "Solicitud de retiro - (US$ ".$this->valorPendientePorReferidos.")";
                $paramsMail["messageBody"] = "El cliente ".$cliente["nombre"]." ha solicitado un retiro de ganancias por referido de  US$ ".$this->valorPendientePorReferidos.". ";
                $mail->enviarMail($paramsMail);
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


    public function consultarCliente(){
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select * from cliente where cliente_id = ".$_SESSION["clientId"];
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
    
    
    public function consultarPaquete($id){
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select * from paquetes where paquete_id = $id";
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

    
    public function consultarRetiros ($tipo = null) {
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        $cond = "";
        
        if ( !empty($tipo) ) {
            $cond .= " AND tipo_retiro = $tipo ";
        }
        
        $sql = "select * from retiros_cliente where cliente_id = ".$_SESSION["clientId"]." $cond ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            $this->misRetiros = [];
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                $this->misRetiros = [];
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $cantRes = count($res);
                    $res[$cantRes] = $fila;
                    
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
                                $res[$cantRes]["paquetes"][] = $fila2;
                            }
                        }
                    }
                    
                }
                $this->misRetiros = $res;
            }
        }
        
    }
    
    

    public function consultarReferidos($id=""){
        $conex = WolfConex::conex();
        
        
        
        if ( empty($id) ){
            $id = $_SESSION["clientId"];
            
            $sql = "select *, 
                        ( coalesce (
			 (select sum(b.valor) 
			 from bonos_referidos b 
			 where b.paquete_cliente_id in ( 
											select p.paquete_cliente_id 
											from paquetes_cliente p 
											where p.cliente_id = cliente.cliente_id 
											and p.estado = 1 
		    								) ) , 0  ) ) as ganancia 
                        from cliente 
                        where cliente.cliente_id = $id";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            if ( !$result ) {
                echo mysqli_error($conex->getLinkConnect());
                return false;
            } else {
                if ( !mysqli_num_rows($result) > 0 ){
                    
                    return false;
                } else {
                    while ($fila = mysqli_fetch_array($result)) {
                        
                        $this->misReferidos[1][$fila["cliente_id"]] = $fila;
                        //$this->misReferidos[2][$id][] = $fila["cliente_id"];
                    }
                    //return $res;
                }
            }
            
        }
        
        $sql = "select ( coalesce ((select sum(b.valor) from bonos_referidos b where b.paquete_cliente_id in ( select p.paquete_cliente_id from paquetes_cliente p where p.cliente_id = c.cliente_id and p.estado = 1 )), 0 ) ) as ganancia
                                , c.*
                from cliente c
                where c.referido = $id";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            return false;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                return false;
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $this->misReferidos[1][$fila["cliente_id"]] = $fila;
                    $this->misReferidos[2][$id][] = $fila["cliente_id"];
                    $this->consultarReferidos($fila["cliente_id"]);
                }
                //return $res;
            }
        }
        
    }

   
    public function imprimirReferidos ( $id = "" ) {
       // echo "<pre>"; var_Export($this->misReferidos[1]); echo "</pre>";
        $primero = false;
        if ( $id == "" ) {
            $id = $_SESSION["clientId"];
            $primero = true;
        }
        
        $dir = "../client/img/clients/";
        
        /*echo "<pre>";
        var_export($this->misReferidos);
        echo "</pre><hr>";*/
        
        if($primero){
            $this->imprimirMisRef .= '<div class="hv-item">';

            $img = $dir."default-user.png";
            
            if( isset($this->misReferidos[1][$id]["foto"]) && !empty($this->misReferidos[1][$id]["foto"]) && file_exists($dir.$this->misReferidos[1][$id]["foto"])){
                $img = $dir.$this->misReferidos[1][$id]["foto"];
            }
            $this->imprimirMisRef .= '<div class="hv-item-parent" title="d">
                                        <div class="person"  data-toggle="tooltip" >
                                            <img src="'.$img.'"> 
                                            <p class="name">
                                                '.$this->misReferidos[1][$id]["nombre"].'<br>
                                            </p>
                                        </div>
                                    </div>';
            
            if( isset($this->misReferidos[1][$id]) && is_array($this->misReferidos[1][$id]) && count($this->misReferidos[1][$id]) > 0 ){
                
                $this->imprimirMisRef .= '<div class="hv-item-children">';
                if ( isset($this->misReferidos[2][$id]) ){
                    foreach ( $this->misReferidos[2][$id] as $idRefp ){
                        
                        if ( isset($_SESSION["clientIsAdmin"]) && $_SESSION["clientIsAdmin"] ) {
                            $this->imprimirReferidos($idRefp);
                        } else {
                            $img = $dir."default-user.png";
                            if( isset($this->misReferidos[1][$idRefp]["foto"]) && !empty($this->misReferidos[1][$idRefp]["foto"]) && file_exists($dir.$this->misReferidos[1][$idRefp]["foto"])){
                                $img = $dir.$this->misReferidos[1][$idRefp]["foto"];
                            }
                            $this->imprimirMisRef .= '<div class="hv-item-child">
                                                    <div class="person">
                                                        <img src="'.$img.'" alt="">
                                                        <p class="name">'.$this->misReferidos[1][$idRefp]["nombre"].'<br>
                                                            <b>US$ '.number_format( $this->misReferidos[1][$idRefp]["ganancia"], 0, '.', ',' ).'</b>
                                                            </p>
                                                    </div>
                                                </div>';
                        }
                        
                    }
                }
                $this->imprimirMisRef .= '</div">';
            }
            
            $this->imprimirMisRef .= '</div>';
        } else {
            
                
            if ( isset($this->misReferidos[2][$id]) && is_array($this->misReferidos[2][$id]) && count($this->misReferidos[2][$id]) > 0 ) {

                $this->imprimirMisRef .= '<div class="hv-item-child">';

                $this->imprimirMisRef .= '<div class="hv-item">';

                $img = $dir."default-user.png";

                if( isset($this->misReferidos[1][$id]["foto"]) && !empty($this->misReferidos[1][$id]["foto"]) && file_exists($dir.$this->misReferidos[1][$id]["foto"])){
                    $img = $dir.$this->misReferidos[1][$id]["foto"];
                }

                $this-> imprimirMisRef .= '<div class="hv-item-parent">
                                                    <div class="person">
                                                        <img src="'.$img.'" alt="" ';
                if ( isset($_SESSION["clientIsAdmin"]) && $_SESSION["clientIsAdmin"] ) {
                    $this->imprimirMisRef .= ' ondblclick="cambiarUsuario('.$id.');" ';
                }
                $this->imprimirMisRef .= '>
                                                        <p class="name">'.$this->misReferidos[1][$id]["nombre"].'</p>
                                                    </div>
                                                </div>';

                $this->imprimirMisRef .= '<div class="hv-item-children">';
                foreach ( $this->misReferidos[2][$id] as $idRef ){
                            $this->imprimirReferidos($idRef);


                }

                $this->imprimirMisRef .= '</div>'; // children

                $this->imprimirMisRef .= '</div>'; // item

                $this->imprimirMisRef .= '</div>'; // child

            } else {
                $img = $dir."default-user.png";
                if( isset($this->misReferidos[1][$id]["foto"]) && !empty($this->misReferidos[1][$id]["foto"]) && file_exists($dir.$this->misReferidos[1][$id]["foto"])){
                    $img = $dir.$this->misReferidos[1][$id]["foto"];
                }
                $this->imprimirMisRef .= '<div class="hv-item-child">
                                        <div class="person">
                                            <img src="'.$img.'" alt=""';
                if ( isset($_SESSION["clientIsAdmin"]) && $_SESSION["clientIsAdmin"] ) {
                    $this->imprimirMisRef .= ' ondblclick="cambiarUsuario('.$id.');" ';
                }
                $this->imprimirMisRef .= '>
                                            <p class="name">'.$this->misReferidos[1][$id]["nombre"].'</p>
                                        </div>
                                    </div>';

            }



        }
        //
        
    }
    
    
    public function guardarNuevaContra($datosForm) {
        
        
        if ( !isset($datosForm["actual"]) || ( isset($datosForm["actual"]) && empty($datosForm["actual"]) ) ) {
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Digite la contraseña actual." ] );        
            return;
        }
        if ( !isset($datosForm["nueva1"]) || ( isset($datosForm["nueva1"]) && empty($datosForm["nueva1"]) ) ) {
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Digite la nueva contraseña." ] );        
            return;
        }
        if ( !isset($datosForm["nueva2"]) || ( isset($datosForm["nueva2"]) && empty($datosForm["nueva2"]) ) ) {
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Digite la confirmacion de su nueva contraseña." ] );
            return;
        }
        if ( $datosForm["nueva1"] != $datosForm["nueva2"] ) {
            echo json_encode( ["respuesta" => false, "error" => 2, "msg" => "La nueva contraseña no coincide con la confirmacion." ] );
            return; 
        }
        
        $conex = WolfConex::conex();

        
        
        $sql = "select * from cliente where cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "No es posible realizar esta solicitud en este momento." ] );
            return;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "No es posible realizar esta solicitud en este momento." ] );
                return;
            } else {
                while ($fila = mysqli_fetch_array($result)) {
                    $cmp = md5($datosForm["actual"]);
                    if ( $cmp != $fila["contrasena"] ) {
                        echo json_encode( ["respuesta" => false, "error" => 2, "msg" => "La contraseña actual digitada, no coincide con la del sistema." ] );
                        return; 
                    }
                    
                }
            }
        }
        
        $sql = "update cliente set contrasena = '". md5($datosForm["nueva2"])."' where cliente_id = ".$_SESSION["clientId"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            //echo "<script>parent.sweetal(\"No es posible actualizar tu perfil en este momento.\");</script>";
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible modificar tu contraseña en este momento." ] );
        } else {
             echo json_encode( ["respuesta" => true, "msg" => "Contraseña actualizada exitosamente."] );
        }

    }

    
    
    public function olvideContrasena() {
        
        $conex = WolfConex::conex();
        
        $sql = "select * from cliente where login = '".$_POST["usuario"]."'";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "No es posible realizar esta solicitud en este momento. $sql" ] );
            return;
        } else {
            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "El usuario que digito ".$_POST["usuario"]." no se encuentra en el sistema." ] );
                return;
            } else {
                $row = mysqli_fetch_array($result);
                $new = rand(1000000, 9999999);
                $sql = "update cliente set contrasena = '". md5($new)."' where cliente_id = ".$row["cliente_id"];
                $result = mysqli_query($conex->getLinkConnect(), $sql);
                if ( !$result ) {
                    //echo "<script>parent.sweetal(\"No es posible actualizar tu perfil en este momento.\");</script>";
                    echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible modificar tu contraseña en este momento.".$sql ] );
                } else {
                     mail($row["correo"], "Nueva clave de acceso.", "Su nueva clave de acceso es $new");
                     echo json_encode( ["respuesta" => true, "msg" => "Se ha enviado una nueva clave al correo ".substr($row["correo"], 0, 5)."xxx@xxxx" ] );
                }
                
            }
        }
        
        
    }
    
    
    public function infoComprarPaquete(){
        
        if ( !isset($_POST["idPaquete"]) || (isset($_POST["idPaquete"]) && empty($_POST["idPaquete"])) ){
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible la compra de paquetes en este momento." ] );
        } else {
            
            $respuesta = [];
            
            $conex = WolfConex::conex();
        
            $comision = ["", 1 => 5, 2 => 10, 3 => 20, 4 => 50];
            
            $sql = "select * from paquetes where paquete_id = ".$_POST["idPaquete"];
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            if ( !$result || !mysqli_num_rows($result) > 0 ) {
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "El paquete que intenta comprar no se encuentra correctamente configurado." ] );
                return;
            } else {
                
                $row = mysqli_fetch_array($result);
            
                
                $this->consultarDatosParaRetiro();
                $this->consultarRetiros();
                $this->consultarDatosParaRetiroReferidos();
                
                $restar = 0;
                foreach ($this->misRetiros as $ret) {
                    if ( $ret["estado"] == 1 ) {
                        $restar += $ret["valor_retiro"];
                    }
                }
                
                $row["valor"] += $comision[$row["paquete_id"]];
                
                $opcion = false;
                $select = "<label for='selectforpag'><select id='selectforpag' class='form-control'>";
                if( ( $this->gananciasInversion - $restar ) >= $row["valor"] || $this->valorPendientePorReferidos >= $row["valor"] || (($this->gananciasInversion - $restar) + $this->valorPendientePorReferidos) >= $row["valor"] ) {
                    
                    $select  .= "<option value='0'>Seleccione opcion de pago.</option>";
                    
                    if ( ($this->gananciasInversion - $restar) >= $row["valor"] ) {
                        $opcion = true;
                        $select  .= "<option value='1'>Descontar el valor de este paquete (US$ ".$row["valor"].") de mis ganancias por paquetes: (".($this->gananciasInversion-$restar).")</option>";
                    }
                    if ( $this->valorPendientePorReferidos >= $row["valor"] ) {
                        $opcion = true;
                        $select  .= "<option value='2'>Descontar el valor de este paquete (US$ ".$row["valor"].") de mis ganancias por referidos: (".$this->valorPendientePorReferidos.")</option>";
                    }
                    if ( (($this->gananciasInversion -$restar ) + $this->valorPendientePorReferidos) >= $row["valor"] && !$opcion ) {
                        $select  .= "<option value='3'>Comprar con todas mis ganancias: (".(($this->gananciasInversion - $restar) + $this->valorPendientePorReferidos) .")</option>";
                    }
                    
                } else {
                    $select  .= "<option  value='0'>No tienes las ganancias necesarias para canjear por este paquete</option>";
                }
                
                $select  .= "</select></label>";

                $body = '<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#home">' .
                                          '<i class="fa fa-bitcoin"></i> Bitcoin</a></li> '.
                                          '<!-- <li><a data-toggle="tab" href="#menu1"> <img src="img/modulos/logo-bancolombia-Copiar.jpg" height="15px">Bancolombia</a></li> -->'.
                                          '<li><a data-toggle="tab" href="#reinvertirTab"><i class="fa fa-exchange"></i> Reinvertir</a></li> '.
                                          '</ul>'.
                                          '<div class="tab-content"><div id="home" class="tab-pane fade in active"><p>Para comprar el paquete <b>'.$row["nombre"].'</b> envia la cantidad de <b>$USD '.number_format(($row["valor"] - $comision[$row["paquete_id"]]), 0, "", ".").' </b> '.
                                          'a la siguiente direccion de Bitcoin &oacute; escanea el codigo QR desde un movil: <br><div style="text-align:center;"> '.
                                          '<img src="img/modulos/qr.png" width="150px;"><br><b>1HZ2wMzf7BPKyoKnw3Y9RAnxJCM9BJMoEK</b></div> <br>'.
                                          'Despues de efectuar el pago ingrese su direccion bitcoin de pago y haz click en confirmar pago.   <div style="text-align:center;">'.
                                          '<input class="form-control round-input" size="20" type="text" name="transaccionBitCoin" id="transaccionBitCoin"></div></p></div>'.

                                          '<div id="menu1" class="tab-pane fade"><p>Para comprar el paquete <b>Principiante</b> consigna la cantidad de <b>100 USD</b> '.
                                          'a la siguiente cuenta de ahorros de Bancolombia: </p><br><div style="text-align:center;">'.
                                          '<img src="img/modulos/qr.png" width="150px;"><br><b>Ahorros xxxx-xxxxxxx</b></div> <br>'.
                                          'Despues de realizar la consignacion ingrese el codigo de la transferencia y haz click en confirmar pago.   <div style="text-align:center;">'.
                                          '<input class="form-control round-input" size="20" type="text" name="transaccionBanco" id="transaccionBanco"></div></p></div>'.

                                          '<div id="reinvertirTab" class="tab-pane fade"><p>Para comprar un paquete <b>'.$row["nombre"].'</b>, podrás reinvertir <b>$USD '.number_format( ($row["valor"] - $comision[$row["paquete_id"]]), 0, "", ".").'</b> '.
                                          'de tus ganancias, en caso de que tengas esa cantidad acumulada: <br><br>'.
                                          '     <div style="text-align:center;"></p>'.
                                          $select.'<br><br><h6>Recuerda que esta transaccion tiene un costo de US$ '.number_format($comision[$row["paquete_id"]], 0, "", ",").'</h6></div> <br>'.
                                          
                                          '</div>  </div>'.

                                          '</div>';

                switch ( $_POST["idPaquete"] ) {

                    case 1 : 
                                $respuesta["respuesta"] = true;
                                $respuesta["title"] = "<img src='img/modulos/principiante.jpg' height='80px'>Paquete Principiante";
                                $respuesta["body"] = $body;
                                $respuesta["footer"] = '<button type="button" class="btn btn-info" onclick="aceptarCompra('.$_POST["idPaquete"].')">Confirmar Pago</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>';

                            break;

                    case 2 : 
                                $respuesta["respuesta"] = true;
                                $respuesta["title"] = "<img src='img/modulos/aprendiz.jpg' height='80px'>Paquete Inversionista";
                                $respuesta["body"] = $body;
                                $respuesta["footer"] = '<button type="button" class="btn btn-info" onclick="aceptarCompra('.$_POST["idPaquete"].')">Confirmar Pago</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>';

                            break;

                    case 3 : 
                                $respuesta["respuesta"] = true;
                                $respuesta["title"] = "<img src='img/modulos/trader.jpg' height='80px'>Paquete Trader";
                                $respuesta["body"] = $body;
                                $respuesta["footer"] = '<button type="button" class="btn btn-info" onclick="aceptarCompra('.$_POST["idPaquete"].')">Confirmar Pago</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>';

                            break;

                    case 4 : 
                                $respuesta["respuesta"] = true;
                                $respuesta["title"] = "<img src='img/modulos/master-vip.jpg' height='80px'>Paquete Master - VIP";
                                $respuesta["body"] = $body;
                                $respuesta["footer"] = '<button type="button" class="btn btn-info" onclick="aceptarCompra('.$_POST["idPaquete"].')">Confirmar Pago</button><button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>';

                            break;

                }
            }
       
            
            echo json_encode( $respuesta );
        }
        
       
    }
    
    
    public function detallarGanancias(){
        
        $conex = WolfConex::conex();
        
        $res = [];
        $cad = $title = "";
        
        $sql = "select * 
                    from paquetes_cliente
                    inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id
                    where paquete_cliente_id = ".$_POST["paquete"];
        
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
           
            while ($fila = mysqli_fetch_array($result)) {
                $res[] = $fila;
            }

            //var_export($res);
            $dias = 0;
            
            $ganx = [];
            foreach ($res as $k => $paq){
                $dias = 0;
                $actualDate = date('Y-m-d'); // ." -> ".$paq["inicia"]." -> ".$paq["finaliza"];
                
                $title = "Ganancias de su paquete ".$paq["nombre"]." de USD$ ". number_format($paq["valor"], 0, "", ".")." con vigencia ".date("d/m/Y", strtotime($paq["inicia"]))." - ".date("d/m/Y", strtotime($paq["finaliza"]));
                /*$initDate = date('Y-m-d', strtotime($paq["inicia"]));
                $finishDate = date('Y-m-d', strtotime($paq["finaliza"]));

                if ($actualDate >= $initDate && $actualDate <= $finishDate ){*/
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
                                $ganx[] = $i;
                                $dias++;
                            }
                        }
                    }

                  //echo "is between -> $meses -> $diasMeses<br>";
                //}

                $valorDia = ($paq["valor"] * ( $paq["rentabilidad"] / 100 ) ) / 20;
                /*$this->gananciasInversion += ($valorDia * $dias);

                $this->gananciasPorPaquete[$k] = $paq;
                $this->gananciasPorPaquete[$k]["ganancia"] = ($valorDia * $dias);*/
            }
                
            
        }
        
        if ( count($ganx) > 0 ){
            rsort($ganx);
            $diasSemana = ["", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
            $mesesAno = ["","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
            $cad .= '<div class="accordion" id="accordionEx" role="tablist" aria-multiselectable="true">';
            $month = "";
            foreach ( $ganx as $timed ){
                
                // Cambio de mes
                if ( $month != date("m", $timed) ) {
                    if ( $month != "" ){
                        
                        // fin Body
                        $cad .= ' </table>
                            </div>
                        </div>';
                        // Fin card
                        $cad .= '</div>';
                    }
                    $cad .= '<div class="card">';
                    
                    // Encabezado
                    $cad .= '<!-- Card header -->
                            <div class="card-header" role="tab" id="headingOne">
                                <a data-toggle="collapse" data-parent="#accordionEx" href="#collapse'.date("Y", $timed).date("m", $timed).'" aria-expanded="false" aria-controls="collapseOne">
                                    <h5 class="mb-0">
                                        '.$mesesAno[intval(date("m", $timed))].' - '.date("Y", $timed).' <i class="fa fa-angle-down rotate-icon"></i>
                                    </h5>
                                </a>
                            </div>';
                    
                    $cad .= '<div id="collapse'.date("Y", $timed).date("m", $timed).'" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordionEx">
                            <div class="card-body">
                            <table class="table"><tr><th>Dia</th><th align="right">Ganaste</th></tr>
                            ';
                                
                            
                    $month = date("m", $timed);
                }
                
                $cad .= '<tr><td>'.$diasSemana[intval(date("N", $timed))].' '.date("d", $timed).' de '.$mesesAno[intval(date("m", $timed))].' de '.date("Y", $timed).'</td><td align="right">USD$ '.$valorDia.' </td>';
                    
            }
            $cad .= '</div>';
        }
        
        
        
        
        echo json_encode( ["respuesta" => true, "msg" => "OK", "imprimir" => $cad, "title" => $title ] );
        
    }

    
    public function consultarTotales() {
        
        
        $conex = WolfConex::conex();
        
        $this->totales = [];
        
        // Consultar Clientes
        $sql = "select count(1) as clientes from cliente";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["clientes"] = $row["clientes"];
        }
        
        // Consultar Paquetes vigentes
        $sql = "select count(1) as vigentes 
                from paquetes_cliente 
                where estado = 1
                and inicia <= current_date
                and finaliza >= current_date";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["paq_vigentes"] = $row["vigentes"];
        }
        
        // Consultar Paquetes pendientes
        $sql = "select count(1) as pendientes 
                from paquetes_cliente 
                where estado = 0";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["paq_pendientes"] = $row["pendientes"];
        }
        
        // Consultar Retiros pendientes
        $sql = "select count(1) as pendientes 
                from retiros_cliente 
                where estado = 0";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["ret_pendientes"] = $row["pendientes"];
        }
        
        // Consultar Total inversiones
        $sql = "select sum(valor) as inver
                from paquetes_cliente
                inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id
                where estado = 1
                ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["tot_inversiones"] = $row["inver"];
        }
        
        // Consultar Total Ganancias Cientes por paquetes
        $sql = "select * 
                    from paquetes_cliente 
                    inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id 
                    where paquetes_cliente.estado = 1"
                . " order by paquetes_cliente.finaliza desc ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        $this->totales["tot_gan_paq"] = 0;
        if ( $result && mysqli_num_rows($result) > 0 ) {
           
            while ($fila = mysqli_fetch_array($result)) {
                $res[] = $fila;
            }

            //var_export($res);
            $dias = 0;
            foreach ($res as $k => $paq){
                $dias = 0;
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
                $this->totales["tot_gan_paq"] += ($valorDia * $dias);

            }
                
            
        }
        
        // Consultar Total Ganancias Cientes por referidos
        $sql = "select sum(valor) as bon_ref
                from bonos_referidos
                ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["tot_gan_referidos"] = $row["bon_ref"];
        }
        
        // Consultar Total Ganancias Pagadas
        $sql = "select sum(valor_retiro) as pagado
                from retiros_cliente
                where estado = 1
                ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["tot_pagado"] = $row["pagado"];
        }

        // Consultar Total Ganancias Inversiones
        $sql = "select sum(valor) as inversion 
                from paquetes_cliente
                inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id
                where paquetes_cliente.estado = 1
                ";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result && mysqli_num_rows($result) > 0 ) {
        
            $row = mysqli_fetch_array($result);
            $this->totales["tot_invertido"] = $row["inversion"];
        }

        $this->totales["tot_pendiente"] = ($this->totales["tot_gan_referidos"] + $this->totales["tot_gan_paq"] ) - $this->totales["tot_pagado"];
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
