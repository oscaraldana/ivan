
<br><br>
<div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i> PAQUETES DE INVERSION</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="fa fa-laptop"></i>Dashboard</li>
            </ol>
            -->
          </div>
        </div>
<div class="row">
    
    
    <?php
        
        $cliente = new cliente();
        $paquetes = $cliente->consultarPaquetes();
        
        if (is_array($paquetes) ) {
            foreach ( $paquetes as $paq ){ ?>
    
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        
                    <div class="info-box dark-bg" style="text-align: center;">
                        <img src="img/modulos/<?= $paq["imagen"] ?>" height="100px" onclick="modalInfo(<?= $paq["paquete_id"] ?>)" style="cursor: pointer">
                    <div class="count" onclick="modalInfo(<?= $paq["paquete_id"] ?>)" style="cursor: pointer; font-size: 25px;"><?= $paq["nombre"] ?></div>
                    <div>Invierte <h3 class="text-warning Bold "><b>US$ <?= number_format($paq["valor"], 0, ",", ".") ?></b></h3></div>
                    <div class="text-primary"><?= $paq["descripcion"] ?></div>
                    <br>
                    <div class="btn btn-info  btn-sm" style="cursor: pointer; font-weight: 25px;" onclick="comprarPaquete(<?= $paq["paquete_id"] ?>)"><b>COMPRAR</b></div>
                  </div>

                </div>
    
            <?php    
            }
        }
    ?>
    
    <!--
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box dark-bg" style="text-align: center;">
          <img src="img/modulos/aprendiz.jpg" height="100px" onclick="modalInfo(2)" style="cursor: pointer">
        <div class="count" onclick="modalInfo(2)" style="cursor: pointer; font-size: 25px;">INVERSIONISTA</div>
        <div class="title">Rentabilidad 18%</div>
        <br>
        <div class="btn btn-info  btn-sm" style="cursor: pointer; font-weight: 25px;" onclick="comprarPaquete(2)"><b>COMPRAR</b></div>
      </div>
    </div>
    
    

    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box dark-bg" style="text-align: center;">
          <img src="img/modulos/trader.jpg" height="100px" onclick="modalInfo(3)" style="cursor: pointer">
        <div class="count" onclick="modalInfo(3)" style="cursor: pointer; font-size: 25px;">TRADER</div>
        <div class="title">Rentabilidad 19%</div>
        <br>
        <div class="btn btn-info  btn-sm" style="cursor: pointer; font-weight: 25px;" onclick="comprarPaquete(3)"><b>COMPRAR</b></div>
      </div>
      
    </div>
    

    
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
      <div class="info-box dark-bg" style="text-align: center;">
          <img src="img/modulos/master-vip.jpg" height="100px" onclick="modalInfo(4)" style="cursor: pointer">
        <div class="count" onclick="modalInfo(4)" style="cursor: pointer; font-size: 25px;">MASTER - VIP</div>
        <div class="title">Rentabilidad 20%</div>
        <br>
        <div class="btn btn-info  btn-sm" style="cursor: pointer; font-weight: 25px;" onclick="comprarPaquete(4)"><b>COMPRAR</b></div>
      </div>
    </div>
    -->
    

  </div>





<!-- Modal -->
<div id="modalBuy" class="modal fade" role="dialog" style="display: none;">
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

