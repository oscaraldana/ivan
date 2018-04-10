<?php

    $cliente = new cliente();
    $cliente->consultarDatosParaRetiro();
    $cuentas = $cliente->consultarMisCuentas();
    
    $cliente->consultarRetiros();
    
    echo "<pre>";
    var_export($cliente->misRetiros);
    echo "</pre>";
    
    $vlrComision = 0;
    $vlrRetirar = 0;
    
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
    
?>

<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;"><b>SOLICITAR RETIRO</b></div>
    <div class="panel-content">
        <table class="table table-hover">
            <tr>
                <th scope="row">Diponible para retirar:</th>
                <td>$ <?php echo $cliente->dispoParaRetiro; ?></td>
              </tr>
              <tr>
                <th scope="row">Comision de retiro:</th>
                <td>$ <?php echo $vlrComision; ?></td>
              </tr>
              <tr>
                <th scope="row">Total a Retirar:</th>
                <td>$ <?php echo $vlrRetirar; ?></td>
              </tr>
              <tr>
                <th scope="row">Metodo de pago:</th>
                <td>
                    <?php if ( !$cuentas ) { 
                        echo "<p class='text-danger'><b>?</b></p>";
                    } else { ?>
                    <select name="metodoPagoRetiro" id="metodoPagoRetiro" class="form-control"><option value="">Seleccione Metodo de Pago</option>
                        <?php 
                        if ( isset($cuentas[0]["banco"]) && !empty($cuentas[0]["banco"]) ){
                            echo '<option value="2">'.$cuentas[0]["banco"].' ***'.substr($cuentas[0]["cuenta"], -3).'</option>';
                        }
                        if ( isset($cuentas[0]["bitcoin"]) && !empty($cuentas[0]["bitcoin"]) ){
                            echo '<option value="1">BITCOIN ***'.substr($cuentas[0]["bitcoin"], -3).'</option>';
                        }
                        ?>
                    </select>
                    <?php } ?>
                </td>
              </tr>

        </table>
        <div style="text-align: center;">
            <?php if ( !$cuentas ) { 
                echo "<p class='text-danger'>No existe configurada ninguna cuenta transaccional para procesar la solicitud de retiro.</p>";
            } else if ( $existeRetiroPendiente ) {
                echo "<p class='text-danger'>Hasta que no se procese la solicitud de retiro pendiente, no es posible realizar una nueva solicitud de retiro.</p>";
            } else {
                ?>
            <button class="btn btn-info" style="cursor: no-drop;" <?= $disabled ?> onclick="solicitarRetiro();">Solicitar Retiro</button>
            <?php } ?>
        </div>
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
                
                echo '  <tr>
                            <td>'.date("d/m/Y", strtotime($misRet["fecha_solicitud"]) ).'</td>
                            <td>'.date("d/m/Y", strtotime($misRet["fecha_pago"]) ).'</td>
                            <td>'.( !empty($misRet["bitcoin"]) ) ? "Bitcoin" : $misRet["banco"] .'</td>
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