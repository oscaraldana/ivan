<?php
$cliente = new cliente();
$cuentas = $cliente->consultarMisCuentas();
//var_export($cuentas);


if( !$cuentas ){ ?>
    
<div class="panel-heading" style="text-align: center;"><h4><b>Mis Cuentas Transaccionales</b></h4></div>

<div class="alert alert-danger" role="alert">
  NO SE HA REGISTRADO UNA CUENTA AUN!
</div>
<div  style="text-align: center;"> <button class="btn btn-info" onclick="formularioCuentasBancarias()">Registrar Mi Cuenta</button> </div>
    </div>

<?php    
} else {
    echo '<input type="hidden" id="infoCuenta" name = "infoCuenta" value="'.serialize($cuentas).'">';
?>
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;"><h4><b>Mis Cuentas Transaccionales</b></h4></div>
    <div class="panel-content">
      
        <br>
        <?php if ( $cuentas[0]["banco"] != "" ) { ?>
        <table class="table table-hover">
            <caption><b>BANCO</b></caption>
            <tr>
                <th scope="row">Entidad</th>
                <th scope="row">Tipo Cuenta</th>
                <th scope="row">Numero</th>
                <th scope="row">Titular</th>
              </tr>
              <tr>
                <td><?= $cuentas[0]["banco"] ?></td>
                <td><?= $cuentas[0]["tipo"] ?></td>
                <td><?= $cuentas[0]["cuenta"] ?></td>
                <td><?= $cuentas[0]["titular"] ?></td>
              </tr>
              
        </table>
        <?php } ?>
<br>
        <?php if ( $cuentas[0]["bitcoin"] != "" ) { ?>
        <table class="table table-hover">
            <caption><b>BITCOIN</b></caption>
            <tr>
                <th scope="row">Numero</th>
              </tr>
              <tr>
                <td><?= $cuentas[0]["bitcoin"] ?></td>
              </tr>
              
        </table>
        <?php } ?>


<div  style="text-align: center;"> <button class="btn btn-info" onclick="formularioCuentasBancarias(<?= $cuentas[0]["cuenta_cliente_id"] ?>)">Modificar</button> </div>
    </div>
</div>
    

<script type="text/javascript">
    var datosCuenta=<?php echo json_encode($cuentas[0]);?>;
</script>
    
<?php } ?>

    
<!-- Modal -->
<div id="modalCuenta" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" name="modal-title" id="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body" id="modal-body" name="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer" id="modal-footer" name="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>