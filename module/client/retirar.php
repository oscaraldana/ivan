<?php

    $cliente = new cliente();
    $cliente->consultarDatosParaRetiro();
    $cliente->consultarDatosParaRetiroReferidos();
    $cuentas = $cliente->consultarMisCuentas();
    
    $cliente->consultarRetiros();
    
    
    $vlrComision = $vlrComRef = 0;
    $vlrRetirar = $vlrRetRef = 0;
    echo $cliente->valorPendientePorReferidos ;
    if ( $cliente->valorPendientePorReferidos > 0 ){
        $vlrComRef = $cliente->valorPendientePorReferidos * ( COMISION_RETIRO / 100 );
        $vlrRetRef = $cliente->valorPendientePorReferidos - $vlrComision;
    }
    
    
    if ( $cliente->dispoParaRetiro > 0 ){
        $vlrComision = $cliente->dispoParaRetiro * ( COMISION_RETIRO / 100 );
        $vlrRetirar = $cliente->dispoParaRetiro - $vlrComision;
    }

    $disabled = "";
    if ( $vlrRetirar <= 0 ){
        $disabled = " disabled ";
    }
    
    $existeRetiroPendiente = false;
    foreach ( $cliente->misRetiros as $misRet ) {
        if ( $misRet["estado"] == "0" ) {
            $existeRetiroPendiente = true;
        }
    }
    
    
    
    $tabla2 = "";
    $tabla = '<table class="table table-hover">
                    <tr>
                        <th scope="row">Diponible para retirar por inversion:</th>
                        <td>$ '.$cliente->dispoParaRetiro.'</td>
                      </tr>
                      <tr>
                        <th scope="row">Comision de retiro:</th>
                        <td>$ '.$vlrComision.'</td>
                      </tr>
                      <tr>
                        <th scope="row">Total a Retirar:</th>
                        <td>$ '.$vlrRetirar.'</td>
                      </tr>
                      <tr>
                        <th scope="row">Metodo de pago:</th>
                        <td>';
    
    
    
        $tabla1 = '<table class="table table-hover">
                    <tr>
                        <th scope="row">Diponible para retirar por referidos:</th>
                        <td>$ '.$cliente->valorPendientePorReferidos.'</td>
                      </tr>
                      <tr>
                        <th scope="row">Comision de retiro:</th>
                        <td>$ '.$vlrComRef.'</td>
                      </tr>
                      <tr>
                        <th scope="row">Total a Retirar:</th>
                        <td>$ '.$vlrRetRef.'</td>
                      </tr>
                      <tr>
                        <th scope="row">Metodo de pago:</th>
                        <td>';

    
    if ( !$cuentas ) { 
        $tabla2 .= "<p class='text-danger'><b>?</b></p>";
    } else {
        $tabla2 .= '<select name="metodoPagoRetiro" id="metodoPagoRetiro" class="form-control"><option value="">Seleccione Metodo de Pago</option>';
                            
        if ( isset($cuentas[0]["banco"]) && !empty($cuentas[0]["banco"]) ){
            $tabla2 .= '<option value="2">'.$cuentas[0]["banco"].' ***'.substr($cuentas[0]["cuenta"], -3).'</option>';
        }
        if ( isset($cuentas[0]["bitcoin"]) && !empty($cuentas[0]["bitcoin"]) ){
            $tabla2 .= '<option value="1">BITCOIN ***'.substr($cuentas[0]["bitcoin"], -3).'</option>';
        }

        $tabla2 .= '</select>';
    }
        
    $tabla2 .= '       </td>
                  </tr>

                </table>';
    
    
    $button = '<div style="text-align: center;">';
                if ( !$cuentas ) { 
                    $button .= "<p class='text-danger'>No existe configurada ninguna cuenta transaccional para procesar la solicitud de retiro.</p>";
                } else if ( $existeRetiroPendiente ) {
                    $button .= "<p class='text-danger'>Hasta que no se procese la solicitud de retiro pendiente, no es posible realizar una nueva solicitud de retiro.</p>";
                } else {
                    
                    $button .= '<button class="btn btn-info" style="cursor: no-drop;" '.$disabled.' onclick="solicitarRetiro();">Solicitar Retiro</button>';
                }
   $button .=  '</div>';
    
?>

<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;"><b>SOLICITAR RETIRO</b></div>
    <div class="panel-content">
        
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#paquetes"><i class="fa fa-money"></i> &nbsp;&nbsp;&nbsp;Retiro por Inversion</a></li>
            <li><a data-toggle="tab" href="#referidos"><i class="fa fa-users"></i> &nbsp;&nbsp;&nbsp;Retiro por Referidos</a></li>
        </ul>
        <div class="tab-content">
            <div id="paquetes" class="tab-pane fade in active">
                <!-- Para Retiros por Inversion -->
                <?php echo $tabla.$tabla2. $button ?>
            </div>
            
            <div id="referidos" class="tab-pane fade">
                <?php echo $tabla1.$tabla2.$button ?>
            </div>
        </div>
        
        
        
        <!-- BUTTON -->
        
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;"><b>HISTORIAL DE RETIROS</b></div>
    <div class="panel-content">
      
        <?php 
        
        if ( is_array($cliente->misRetiros) && count($cliente->misRetiros) > 0 ) {

            echo '<table class="table table-hover">
            <tr>
                <th scope="row">Fecha Solicitud</th>
                <th scope="row">Fecha Pago</th>
                <th scope="row">Metodo</th>
                <th scope="row">Tipo</th>
                <th scope="row">Cantidad</th>
                <th scope="row">Estado</th>
              </tr>';
            
            
              
            
            foreach ( $cliente->misRetiros as $misRet ) {
                $estado = "";
                
                switch ( $misRet["estado"] ) {
                    case "0" : $estado = "Pendiente"; break;
                    case "1" : $estado = "Pagado"; break;
                    case "2" : $estado = "Rechazado"; break;
                }
                
                $metodo = ( !empty($misRet["bitcoin"]) ) ? "Bitcoin" : $misRet["banco"];
                echo '  <tr>
                            <td>'.date("d/m/Y", strtotime($misRet["fecha_solicitud"]) ).'</td>
                            <td>'.date("d/m/Y", strtotime($misRet["fecha_pago"]) ).'</td>
                            <td>'.$metodo.'</td>
                            <td>Inversion</td>
                            <td align="right">$ '.$misRet["valor_retiro"].'</td>
                            <td><span class="badge">'.$estado.'</span></td>
                          </tr>';
            }
            
            echo '</table>';
            
        } else {
        
            echo "<h5>No existen registros de solicitudes de retiro para mostrar.</h5>";
        }
        ?>
        
    </div>
</div>