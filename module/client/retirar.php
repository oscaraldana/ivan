<?php

    $cliente = new cliente();
    $cliente->consultarDatosParaRetiro();
    
    $comision = 5;
    
    $vlrComision = 0;
    $vlrRetirar = 0;
    
    if ( $cliente->dispoParaRetiro > 0 ){
        $vlrComision = $cliente->dispoParaRetiro * ( $comision / 100 );
        $vlrRetirar = $cliente->dispoParaRetiro - $vlrComision;
        
        //echo '<input type="hidden" name="ipr_" id="ipr_" value="'. serialize($cliente->gananciasPorPaquete).'">';
    }

    $disabled = "";
    if ( $vlrRetirar <= 0 ){
        $disabled = " disabled ";
    }
?>

<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;">Solicitar Retiro</div>
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
                <td><select name="metodoPagoRetiro" id="metodoPagoRetiro"><option value="1">BITCOIN</option><option value="2">CUENTA BANCARIA</option></select></td>
              </tr>

        </table>
        <div style="text-align: center;">
            <button class="btn btn-info" style="cursor: no-drop;" <?= $disabled ?> onclick="solicitarRetiro();">Solicitar Retiro</button>
        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;">Historial de Retiros</div>
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