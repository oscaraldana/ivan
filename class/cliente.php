<?php

class cliente {
    
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
    
    
}
