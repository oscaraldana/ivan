<?php

    $cliente = new cliente();
    $cliente->consultarDatosParaRetiro();
    $cuentas = $cliente->consultarMisCuentas();
    
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
            } else if ( $cliente->tieneR() ) { ?>
            <button class="btn btn-info" style="cursor: no-drop;" <?= $disabled ?> onclick="solicitarRetiro();">Solicitar Retiro</button>
            <?php } ?>
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;"><b>HISTORIAL DE RETIROS</b></div>
    <div class="panel-content">
      
        <table class="table table-hover">
            <tr>
                <th scope="row">Fecha Solicitud</th>
                <th scope="row">Fecha Pago</th>
                <th scope="row">Metodo</th>
                <th scope="row">Tipo</th>
                <th scope="row">Cantidad</th>
                <th scope="row">Estado</th>
              </tr>
              <tr>
                <td>10/01/2018</td>
                <td>20/01/2018</td>
                <td>BITCOIN</td>
                <td>REFERIDO</td>
                <td>$200</td>
                <td><span class="badge">Pagado</span></td>
              </tr>
              
        </table>
        
    </div>
</div>