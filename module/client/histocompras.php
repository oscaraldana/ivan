
<div class="panel panel-default">
    <div class="panel-heading" style="text-align: center;">Historial de Compras</div>
    <div class="panel-content">
      
        <table class="table table-hover">
            <tr>
                <th scope="row">Fecha Compra</th>
                <th scope="row">Paquete</th>
                <th scope="row">Valor</th>
                <th scope="row">Forma Compra</th>
                <th scope="row">Estado</th>
              </tr>
              
              <?php 
              
              $cliente = new cliente();
              
              $misPaquetes = $cliente->consultarPaquetesCliente();
              
              if (is_array($misPaquetes) && count($misPaquetes) > 0 ) {
              
                  foreach ( $misPaquetes as $paq ) {
              
                      $estado = $class = "";
                      switch ( $paq["estado"] ) {
                          case 0 : $estado = "Pendiente"; $class = "badge badgeP"; break;
                          case 1 : $estado = "Activo"; $class = "badge"; break;
                          case 2 : $estado = "Vencido"; $class = "badge badgeV"; break;
                          case 3 : $estado = "Rechazado"; $class = "badge badgeR"; break;
                      }
              ?>
                    <tr>
                      <td><?= $paq["fecha_registro"] ?></td>
                      <td><?= $paq["paquete"] ?></td>
                      <td>$ <?= $paq["valor"] ?></td>
                      <td><?= $paq["tipo_pago"] ?></td>
                      <td><span class="<?= $class ?>"><?= $estado ?></span></td>
                    </tr>

            <?php 
                  }
              }
            ?>
              
        </table>
        
    </div>
</div>