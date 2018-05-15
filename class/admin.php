<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of partner
 *
 * @author oscar.aldana
 */
class admin {
    //put your code here
    
    public function getEstados() {
        /*
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
        */
        
        $estados = [ "-1" => "Todos", "0" => "Pendiente", "1" => "Activo", "2" => "Rechazado", "3" => "Inactivo" ];
        return $estados;
    }
    
    
    public function listarPaquetes($dataForm){
        
        
        //var_export($dataForm); 
        
        $cond = "";
        $list = "";
        if ( isset($dataForm["paqestado"]) && $dataForm["paqestado"] != "" ){
            $cond .= ' AND paqcli.estado = '.$dataForm["paqestado"].' ';
        }
        if ( isset($dataForm["iniCompra"]) && $dataForm["iniCompra"] != "" ){
            $cond .= ' AND paqcli.fecha_registro >= \''.$dataForm["iniCompra"].'\' ';
        }
        if ( isset($dataForm["finCompra"]) && $dataForm["finCompra"] != "" ){
            $cond .= ' AND paqcli.fecha_registro <= \''.$dataForm["finCompra"].'\' ';
        }
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select paqcli.*, paq.valor, paq.nombre, cli.nombre as cliente
                from paquetes_cliente paqcli
                inner join paquetes paq on paq.paquete_id = paqcli.paquete_id 
                inner join cliente cli on cli.cliente_id = paqcli.cliente_id
                where true $cond";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result ) {
            
            if ( mysqli_num_rows($result) > 0 ){
                
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
                
            }
        }
        
        if ( count($res) > 0 ) {
        
            $list = '
                <br>
                <table class="table table-hover" id="tablePaqAdmin">
                <thead>
                <tr>
                    <th scope="row">Fecha Compra</th>
                    <th scope="row">Cliente</th>
                    <th scope="row">Paquete</th>
                    <th scope="row">Valor</th>
                    <th scope="row">Forma Compra</th>
                    <th scope="row">Ref Compra</th>
                    <th scope="row">Estado</th>
                  </tr>
                  </thead>
                  <tbody>
                  ';

                foreach ( $res as $paq ) {

                    $estado = $class = "";
                    switch ( $paq["estado"] ) {
                        case 0 : $estado = "Pendiente"; $class = "badge badgeP"; break;
                        case 1 : $estado = "Activo"; $class = "badge"; break;
                        case 2 : $estado = "Rechazado"; $class = "badge badgeR"; break;
                        case 3 : $estado = "Vencido"; $class = "badge badgeV"; break;
                        
                    }

                    $list .='  <tr>
                          <td>'.$paq["fecha_registro"].'</td>
                          <td>'.$paq["cliente"].'</td>
                          <td>'.$paq["nombre"].'</td>
                          <td>$ '.$paq["valor"].'</td>
                          <td>'.$paq["tipo_pago"].'</td>
                          <td>'.$paq["referencia_pago"].'</td>
                          <td><span class="'. $class.'" style="cursor:pointer;" onclick="editarPaquete('.$paq["paquete_cliente_id"].')">'. $estado.'</span></td>
                        </tr>';

                }
                


            $list .= '</tbody></table>';
        } else {
            $list .= '<br><h4>No hay registros para mostrar.</h4>';
        }
        
       echo json_encode( ["respuesta" => true, "tabla" => $list ] );
    }
 
    
    
    
    public function listarRetiros($dataForm){
        
        
        //var_export($dataForm); 
        
        $cond = "";
        $list = "";
        if ( isset($dataForm["retestado"]) && $dataForm["retestado"] != "" ){
            $cond .= ' AND retiros_cliente.estado = '.$dataForm["retestado"].' ';
        }
        if ( isset($dataForm["inisoli"]) && $dataForm["inisoli"] != "" ){
            $cond .= ' AND retiros_cliente.fecha_solicitud >= \''.$dataForm["inisoli"].'\' ';
        }
        if ( isset($dataForm["finsoli"]) && $dataForm["finsoli"] != "" ){
            $cond .= ' AND retiros_cliente.fecha_solicitud <= \''.$dataForm["finsoli"].'\' ';
        }
        
        $conex = WolfConex::conex();
        
        $res = [];
        
        $sql = "select retiros_cliente.*, cliente.nombre as cliente 
                from retiros_cliente
                inner join cliente on cliente.cliente_id = retiros_cliente.cliente_id
                where true $cond";
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( $result ) {
            
            if ( mysqli_num_rows($result) > 0 ){
                
                while ($fila = mysqli_fetch_array($result)) {
                    $res[] = $fila;
                }
                
            }
        }
        
        if ( count($res) > 0 ) {
        
            $list = '
                <br>
                <table class="table table-hover">
                <tr>
                    <th scope="row">Fecha Solicitud</th>
                    <th scope="row">Cliente</th>
                    <th scope="row">Valor</th>
                    <th scope="row">Forma Pago</th>
                    <th scope="row">Fecha Pago</th>
                    <th scope="row">Estado</th>
                  </tr>

                  ';

                foreach ( $res as $ret ) {

                    $estado = $class = "";
                    switch ( $ret["estado"] ) {
                        case 0 : $estado = "Pendiente"; $class = "badge badgeP"; break;
                        case 1 : $estado = "Pagado"; $class = "badge"; break;
                        case 2 : $estado = "Rechazado"; $class = "badge badgeR"; break;
                        case 3 : $estado = "Vencido"; $class = "badge badgeV"; break;
                        
                    }
                    if ( !empty($ret["bitcoin"]) ){
                        $forma = "BITCOIN";
                    } else {
                        $forma = $ret["banco"];
                    }

                    $list .='  <tr>
                          <td>'.date("d/m/Y", strtotime($ret["fecha_solicitud"])).'</td>
                          <td>'.$ret["cliente"].'</td>
                          <td>$ '.$ret["valor_retiro"].'</td>
                          <td>'.$forma.'</td>
                          <td>'.$ret["fecha_pago"].'</td>
                          <td><span class="'. $class.'" style="cursor:pointer;" onclick="editarRetiro('.$ret["retiro_id"].')">'. $estado.'</span></td>
                        </tr>';

                }
                


            $list .= '</table>';
        } else {
            $list .= '<br><h4>No hay registros para mostrar.</h4>';
        }
        
       echo json_encode( ["respuesta" => true, "tabla" => $list ] );
    }
    
    
    
    public function consultapaquete () {
        
        if(isset($_POST["paquete_id"]) && !empty($_POST["paquete_id"]) ){
    
            $conex = WolfConex::conex();
            
            $sql = "select c.nombre, paqcli.*, p.nombre as paquete, p.valor,
                    case 
                        when paqcli.estado = 0 then 'Pendiente'
                        when paqcli.estado = 1 then 'Activo'
                        when paqcli.estado = 2 then 'Rechazado'
                        when paqcli.estado = 3 then 'Vencido'
                        else 'Indefinido'
                    end as desc_estado,
                    paqcli.estado
                    from paquetes_cliente paqcli
                    inner join cliente c on c.cliente_id = paqcli.cliente_id
                    inner join paquetes p on p.paquete_id = paqcli.paquete_id
                    where paqcli.paquete_cliente_id = ".$_POST["paquete_id"]." ";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            $gananciasDispo = "";
            
            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Los datos del paquete no se encuentran disponibles!" ] );
            } else {
                
                $states[0] = [ "0" => "Pendiente", "1" => "Activo", "2" => "Rechazado" ];
                $states[1] = [ "0" => "#eb984e", "1" => "#5dade2", "2" => "#c0392b" ];
                $select = "<select class='form-control' onchange='validarEstadoPaq()' name='selectEstado' id='selectEstado'>";
                foreach ( $states[0] as $k => $val ){
                    $selected = "";
                    if ( $k == $row["estado"] ) { $selected = " selected "; }
                    $select .= '<option style="background: '.$states[1][$k].'; color: #fff;" value="'.$k.'" '.$selected.'>'.$val.'</option>';
                }
                $select .= '</select>';
                
                
                
                
                if( isset($row["valor"]) ) { $row["valor"] = number_format($row["valor"], 2, ',', '.'); }
                if( isset($row["fecha_registro"]) ) { $row["fecha_registro"] = date("d/m/Y", strtotime($row["fecha_registro"]) ); }
                if( isset($row["inicia"]) && !empty($row["inicia"]) ) { $row["inicia_"] = date("d/m/Y", strtotime($row["inicia"]) ); } else { $row["inicia"] = date("Y-m-d"); }
                if( isset($row["finaliza"]) && !empty($row["finaliza"]) ) { $row["finaliza_"] = date("d/m/Y", strtotime($row["finaliza"]) ); } else { $row["finaliza"] = date ( 'Y-m-d' , strtotime ( '+1 year' , strtotime ( date('Y-m-d') ) ) ); }
                
                if ( isset($row["referencia_pago"]) && $row["referencia_pago"] == "Ganancias Paquetes" ) {
                    $cliente = new cliente();
                    $cliente->consultarDatosParaRetiro();
                    $cliente->consultarRetiros();
                    $cliente->consultarDatosParaRetiroReferidos();
                    
                    $restar = 0;
                    foreach ($cliente->misRetiros as $ret) {
                        if ( $ret["estado"] == 1 ) {
                            $restar += $ret["valor_retiro"];
                        }
                    }
                    
                    $gananciasDispo = "<tr><td>Ganancias Acumuladas:</td><td class='text-right'>US$ ".number_format( (($cliente->gananciasInversion -$restar ) + $cliente->valorPendientePorReferidos), 2, ',', '.')."<td></tr>";
                    $select .= '<input type="hidden" name="reinvertir" id="reinvertir" value="true">';
                    
                }
                
                echo json_encode( ["respuesta" => true, "msg" => "Datos de paquete", "datos" => $row, "estados" => $select, "ganancias_dispo" => $gananciasDispo ] );
            }
        }
    }
    
    
    
    public function consultaretiro () {
        
        if(isset($_POST["retiro_id"]) && !empty($_POST["retiro_id"]) ){
    
            $conex = WolfConex::conex();
            
            $sql = "select c.nombre, retcli.* ,
                    case 
                        when retcli.estado = 0 then 'Pendiente'
                        when retcli.estado = 1 then 'Pagado'
                        when retcli.estado = 2 then 'Rechazado'
                        when retcli.estado = 3 then 'Vencido'
                        else 'Indefinido'
                    end as desc_estado,
                    case 
                    	when retcli.tipo_retiro = 1 then 'Inversion'
                    	when retcli.tipo_retiro = 2 then 'Referidos'
                    	else 'Indefinido'
                   	end as tipo_des
                    from retiros_cliente retcli
                    inner join cliente c on c.cliente_id = retcli.cliente_id
                    where retcli.retiro_id = ".$_POST["retiro_id"]." ";
            $result = mysqli_query($conex->getLinkConnect(), $sql);
            $row = mysqli_fetch_array($result);

            if ( !mysqli_num_rows($result) > 0 ){
                echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "Los datos del retiro no se encuentran disponibles!" ] );
            } else {
                
                $states[0] = [ "0" => "Pendiente", "1" => "Pagado", "2" => "Rechazado" ];
                $states[1] = [ "0" => "#eb984e", "1" => "#5dade2", "2" => "#c0392b" ];
                $select = "<select class='form-control' name='selectEstado' id='selectEstado'>";
                foreach ( $states[0] as $k => $val ){
                    $selected = "";
                    if ( $k == $row["estado"] ) { $selected = " selected "; }
                    $select .= '<option value="'.$k.'" '.$selected.'>'.$val.'</option>';
                }
                $select .= '</select>';
                
                $formaPgo = "";
                if( !empty($row["bitcoin"]) ) {
                    $formaPgo .= "<tr><td>Forma Pago:</td><td class='text-right'>BITCOIN<td></tr>";
                    $formaPgo .= "<tr><td>Cuenta Pago:</td><td class='text-right'>".$row["bitcoin"]."<td></tr>";
                } else {
                    $formaPgo .= "<tr><td>Forma Pago:</td><td class='text-right'>".$row["banco"]."<td></tr>";
                    $formaPgo .= "<tr><td>Cuenta Pago:</td><td class='text-right'>".$row["cuenta"]."<td></tr>";
                    $formaPgo .= "<tr><td>Tipo Cuenta:</td><td class='text-right'>".$row["tipo_cuenta"]."<td></tr>";
                    $formaPgo .= "<tr><td>Titular Cuenta:</td><td class='text-right'>".$row["titular"]."<td></tr>";
                }
                
                
                if( isset($row["valor"]) ) { $row["valor"] = number_format($row["valor"], 2, ',', '.'); }
                if( isset($row["fecha_solicitud"]) ) { $row["fecha_solicitud"] = date("d/m/Y", strtotime($row["fecha_solicitud"]) ); }
                
                echo json_encode( ["respuesta" => true, "msg" => "Datos de retiro", "datos" => $row, "estados" => $select, "formaPago" => $formaPgo ] );
            }
        }
    }
    

    public function actualizarPaquete ( $dataPost ) {
        
        if ( $dataPost["selectEstado"] == "1" && ( empty($dataPost["datefecinipaq"]) || empty($dataPost["datefecfinpaq"]) ) ) {
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "Por favor seleccione las fechas de vigencia del paquete." ] );
            return;
        }
        
        $conex = WolfConex::conex();
        
        // Consultamos el estado actual del paquete
        $sql = "select paquetes_cliente.*, paquetes.valor 
                from paquetes_cliente 
                inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id
                where paquete_cliente_id = ".$dataPost["paquete_id"];
        $res = mysqli_query($conex->getLinkConnect(), $sql);
        $paqAct = mysqli_fetch_array($res);
        
        $sql = "update paquetes_cliente set estado = '".$dataPost["selectEstado"]."', fecha_activacion = now(), inicia = '".$dataPost["datefecinipaq"]."', finaliza = '".$dataPost["datefecfinpaq"]."' where paquete_cliente_id = ".$dataPost["paquete_id"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            //echo "<script>parent.sweetal(\"No es posible actualizar tu perfil en este momento.\");</script>";
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible modificar este paquete en este momento.".$sql ] );
        } else {
            
            // Dar bonificacion por compra de paquete de referido
            if ( $dataPost["selectEstado"] == "1" ) {
                
                $sql = "select * from bonos_referidos where paquete_cliente_id = ".$dataPost["paquete_id"];
                $res = mysqli_query($conex->getLinkConnect(), $sql);
                $bonoRef = mysqli_fetch_array($res);
                if ( count($bonoRef) <= 0 ) {
                    
                    $sql = "insert into bonos_referidos (paquete_cliente_id, valor) values 
                           ( ".$dataPost["paquete_id"].", '".( $paqAct["valor"] * 0.05 )."' );";
                    $res = mysqli_query($conex->getLinkConnect(), $sql);
                }

                
            }
            
            
            echo json_encode( ["respuesta" => true, "msg" => "Paquete actualizado correctamente."] );
        }
        
        
    }
    
    
    public function actualizarRetiro ( $dataPost ) {
        
        
        $conex = WolfConex::conex();
        
        $sql = "update retiros_cliente set estado = '".$dataPost["selectEstado"]."', fecha_pago = now() where retiro_id = ".$dataPost["retiro_id"];
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            //echo "<script>parent.sweetal(\"No es posible actualizar tu perfil en este momento.\");</script>";
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible modificar este retiro en este momento." ] );
        } else {
            
            /*if ( $dataPost["selectEstado"] == "1" ) {
                
                $sql = "select * from bonos_referidos where paquete_cliente_id = ".$dataPost["paquete_id"];
                $res = mysqli_query($conex->getLinkConnect(), $sql);
                $bonoRef = mysqli_fetch_array($res);
                if ( count($bonoRef) <= 0 ) {
                    
                    $sql = "insert into bonos_referidos (paquete_cliente_id, valor) values 
                           ( ".$dataPost["paquete_id"].", '".( $paqAct["valor"] * 0.05 )."' );";
                    $res = mysqli_query($conex->getLinkConnect(), $sql);
                }

                
            }*/
            
            
             echo json_encode( ["respuesta" => true, "msg" => "Retiro actualizado correctamente."] );
        }
        
        
    }
    
    
    public function aprobarReinversion($dataPost, $codPaquete){ // 1 paquetes, 2 referidos, 3 paquetes y referidos
        
        if(empty($codPaquete)) {
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible la compra de este paquete en este momento." ] );
            return;
        }
        
        $conex = WolfConex::conex();
        $cliente = new cliente();
        
        mysqli_autocommit($conex->getLinkConnect(), FALSE); // turn OFF auto
        
        $comision = ["", 1 => 5, 2 => 10, 3 => 20, 4 => 50];
        
        $exito = true;
        
        // Actualizamos estado y fechas de paquete nuevo
        $sql = "update paquetes_cliente set estado = '1', fecha_activacion = now(), inicia = CURDATE() + INTERVAL 5 day, finaliza = CURDATE() + INTERVAL 5 day + interval 1 year where paquete_cliente_id = ".$codPaquete;
        $result = mysqli_query($conex->getLinkConnect(), $sql);
        if ( !$result ) {
            //echo "<script>parent.sweetal(\"No es posible actualizar tu perfil en este momento.\");</script>";
            $exito = false;
            echo json_encode( ["respuesta" => false, "error" => 3, "msg" => "No es posible modificar este paquete en este momento." ] );
            return;
        }
        
        /********************************* INTENTAR HACER RETIRO VIRTUAL PARA REINVERTIR EN PAQUETE    *********************/
        // Consultamos el paquete a comprar
        $sql = "select *
                from paquetes_cliente
                inner join paquetes on paquetes.paquete_id = paquetes_cliente.paquete_id
                where paquete_cliente_id = ".$codPaquete;
        $res = mysqli_query($conex->getLinkConnect(), $sql);
        $paqBuy = mysqli_fetch_array($res);
        
        
        // Por inversion
        if ( $dataPost["opcionReinvertir"] == "1" ){
            
            $bitcoin = "";
            $banco = "";
            $tipo = "99999";
            $cuenta = "1";
            $titular = "";
            $valorPaquete = $paqBuy["valor"] + $comision[$paqBuy["paquete_id"]];

            
            
            
            $cliente->consultarDatosParaRetiro();
            $cliente->consultarRetiros();
            
            $restar = 0;
            foreach ($cliente->misRetiros as $ret) {
                if ( $ret["estado"] == 1 ) {
                    $restar += $ret["valor_retiro"];
                }
            }
            
            
            
            if ( $cliente->dispoParaRetiro > 0 ){


                $vlrComision = $cliente->dispoParaRetiro * ( COMISION_RETIRO / 100 );
                $vlrRetirar = $cliente->dispoParaRetiro - $vlrComision;

                $sql = "insert into retiros_cliente ( cliente_id, valor_retiro, valor_comision, valor_pagado, bitcoin, banco, cuenta, tipo_cuenta, titular, estado, tipo_retiro ) values "
                                                    . "( ".$_SESSION["clientId"].", '".$valorPaquete."', '".$comision[$paqBuy["paquete_id"]]."', '".($valorPaquete - $comision[$paqBuy["paquete_id"]])."', '".$bitcoin."', '".$banco."', '".$cuenta."', '".$tipo."', '".$titular."', 1, '3' )";
                
                $result = mysqli_query($conex->getLinkConnect(), $sql);

                
                $retId = "";
                if ( !$result ) {
                    $exito = false;
                } else {
                    $retId = mysqli_insert_id($conex->getLinkConnect());
                }


                if ( $exito && !empty($retId) ) {

                    var_export($cliente->gananciasPorPaquete);
                    /*foreach ( $cliente->gananciasPorPaquete as $ganPaq ) {

                        if ( $ganPaq["ganancia"] >= $ganPaq["retiro_minimo"] ) {

                            $sql = " insert into retiros_paquetes (retiro_cliente_id, paquete_cliente_id, valor_retiro) values ($retId, ".$ganPaq["paquete_cliente_id"].", '".$ganPaq["ganancia"]."' ) ";
                            $result = mysqli_query($conex->getLinkConnect(), $sql);
                            if ( !$result ) {
                                $exito = false;
                                break;
                            }

                        }

                    }*/
                    /*BORRAR*/
                    mysqli_rollback($conex->getLinkConnect());
                    mysqli_autocommit($conex->getLinkConnect(), TRUE); // turn ON auto
                    return;
                }

                if ( !$exito ) {
                    mysqli_rollback($conex->getLinkConnect());
                    echo json_encode( ["respuesta" => false, "error" => 1, "msg" => "No es posible registrar tu solicitud en este momento." ] );
                } else {
                    echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, pronto se hara efectivo tu retiro." ] );
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
                mysqli_rollback($conex->getLinkConnect());
                echo json_encode( ["respuesta" => false, "error" => 2, "msg" => "No es posible registrar tu solicitud en este momento." ] );
            } else {
                //mysqli_commit($conex->getLinkConnect());
                mysqli_rollback($conex->getLinkConnect());
                echo json_encode( ["respuesta" => true, "msg" => "Tu solicitud se ha registrado, pronto se hara efectivo tu retiro." ] );
            }
            
        }
        
        mysqli_autocommit($conex->getLinkConnect(), TRUE); // turn ON auto
    }
    
    
}
