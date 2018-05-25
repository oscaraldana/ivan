<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="shortcut icon" href="img/favicon.png">

  <title>Admin Wolves Traders</title>

  <!-- Bootstrap CSS -->
  <link href="../client/css/bootstrap.min.css" rel="stylesheet">
  <!-- bootstrap theme 
  <link href="../client/css/bootstrap-theme.css" rel="stylesheet">-->
  <!--external css-->
<a href="dashboard.php"></a>
  <!-- font icon -->
  <link href="../client/css/elegant-icons-style.css" rel="stylesheet" />
  <link href="../client/css/font-awesome.min.css" rel="stylesheet" />
  <!-- full calendar css-->
  <link href="../client/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
  <link href="../client/assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
  <!-- easy pie chart-->
  <link href="../client/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen" />
  <!-- owl carousel -->
  <link rel="stylesheet" href="../client/css/owl.carousel.css" type="text/css">
  <link href="../client/css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
  <!-- Custom styles -->
  <link rel="stylesheet" href="../client/css/fullcalendar.css">
  <link href="../client/css/widgets.css" rel="stylesheet">
  <link href="../client/css/style.css" rel="stylesheet">
  <link href="../client/css/style-responsive.css" rel="stylesheet" />
  <link href="../client/css/xcharts.min.css" rel=" stylesheet">
  <link href="../client/css/jquery-ui-1.10.4.min.css" rel="stylesheet">
  <link href="../client/css/bootstrap-select.min.css" rel="stylesheet">
  <link href="../../css/datatables.css" rel="stylesheet">
  <!-- =======================================================
    Theme Name: NiceAdmin
    Theme URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    Author: BootstrapMade
    Author URL: https://bootstrapmade.com
  ======================================================= -->
  
  <style>
      body::after {
             content: "";
             background: url(../../images/wolvess.jpeg);
             background-repeat:no-repeat;
             background-size: cover;
             opacity: 0.2;
             top: 0;
             left: 0;
             bottom: 0;
             right: 0;
             position: absolute;
             z-index: -1;   
           }           
  </style>
</head>

<body>
  <!-- container section start -->
  <section id="container" class="">


    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>

      <!--logo start-->
      <a href="../admin/" class="logo"><img src="../../images/wolvess.jpeg" width="40px" ><span class="lite" style="font-size: 15px;"><b> Wolves Traders Admin</b></span> </a>
      <!--logo end-->

      <div class="top-nav notification-row">
        <!-- notificatoin dropdown start-->
        <ul class="nav pull-right top-menu">

          
          <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <?php 
                                if (isset($_SESSION["clientImg"]) && !empty($_SESSION["clientImg"]) && file_exists("../client/img/clients/".$_SESSION["clientImg"]) ){
                                    echo '<img alt="" src="../client/img/clients/'.$_SESSION["clientImg"].'" height="43px"  id="imgPerfil" name="imgPerfil">';
                                } else {
                                    echo '<img alt="" src="img/clients/default-user.png" height="43px" id="imgPerfil" name="imgPerfil">';
                                }
                                    ?>
                                
                            </span>
                            <span class="username"  id="nomPerfil" name="nomPerfil"> <?php echo $_SESSION["clientNombre"] ?> </span>
                            <b class="caret"></b>
                        </a>
            <ul class="dropdown-menu extended logout">
              <div class="log-arrow-up"></div>
              <li class="eborder-top">
                  <a href="javascript:;" onclick="miperfil()"><i class="icon_profile"></i> Mi Perfil</a>
              </li>
              <li>
                  <a href="javascript:;" onclick="cambiarContra()"><i class="icon_key_alt"></i> Cambiar Contraseña</a>
              </li>
              <li>
                  <a href="javascript:;" onclick="logout()"><i class="arrow_back"></i> Salir</a>
              </li>
              <!--<li>
                <a href="#"><i class="icon_mail_alt"></i> My Inbox</a>
              </li>
              <li>
                <a href="#"><i class="icon_clock_alt"></i> Timeline</a>
              </li>
              <li>
                <a href="#"><i class="icon_chat_alt"></i> Chats</a>
              </li>
              <li>
                <a href="login.html"><i class="icon_key_alt"></i> Log Out</a>
              </li>
              <li>
                <a href="documentation.html"><i class="icon_key_alt"></i> Documentation</a>
              </li>
              
              <li>
                <a href="javascript:;" onclick="logout()"><i class="icon_key_alt"></i> salir</a>
              </li>-->
            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->

    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
          <li class="active">
              <a class="" href="../admin/">
                          <i class="icon_house_alt"></i>
                          <span>Inicio</span>
                      </a>
          </li>
          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Administrar</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="javascript:;" onclick="cargarHtml('adm_paquetes');">Paquetes Clientes</a></li>
              <li><a class="" href="javascript:;" onclick="cargarHtml('adm_retiros');">Retiros Clientes</a></li>
              <!--<li><a class="" href="javascript:;" onclick="cargarHtml('histocompras');">Historial de Compra</a></li>
              -->
            </ul>
          </li>
          <li>
            <a class="" href="javascript:;" onclick="cargarHtml('../client/referidos');">
                          <i class="icon_group"></i>
                          <span>Ver Clientes</span>
                      </a>
          </li>
          <li>
            <a class="" href="../client">
                          <i class="icon_profile"></i>
                          <span>Modulo Clientes</span>
                      </a>
          </li>
          <!--<li>
            <a class="" href="javascript:;" onclick="cargarHtml('referidos');">
                          <i class="icon_group"></i>
                          <span>Mis Referidos</span>
                      </a>
          </li>
          <li>
            <a class="" href="widgets.html">
                          <i class="icon_genius"></i>
                          <span>Widgets</span>
                      </a>
          </li>
          <li>
            <a class="" href="chart-chartjs.html">
                          <i class="icon_piechart"></i>
                          <span>Charts</span>

                      </a>

          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_table"></i>
                          <span>Tables</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="basic_table.html">Basic Table</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" class="">
                          <i class="icon_documents_alt"></i>
                          <span>Pages</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
            <ul class="sub">
              <li><a class="" href="profile.html">Profile</a></li>
              <li><a class="" href="login.html"><span>Login Page</span></a></li>
              <li><a class="" href="contact.html"><span>Contact Page</span></a></li>
              <li><a class="" href="blank.html">Blank Page</a></li>
              <li><a class="" href="404.html">404 Error</a></li>
            </ul>
          </li>
-->
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
    
      <section class="wrapper">
    <div id="homeContent" name="homeContent">   
          <!--overview start-->
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-laptop"></i> Panel del Administrador</h3>
            <!--<ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.html">Home</a></li>
              <li><i class="fa fa-laptop"></i>Dashboard</li>
            </ol>
            -->
          </div>
        </div>

        <?php
        
        $cliente = new cliente();
        
        $cliente->consultarTotales();
        
        ?>
          
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Clientes</span>
              <div class="count"><?= $cliente->totales["clientes"]?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-dollar"></i> Paquetes Vigentes</span>
              <div class="count"><?= $cliente->totales["paq_vigentes"]?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Paquetes Pendientes</span>
              <div class="count green"><?= $cliente->totales["paq_pendientes"]?></div>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Retiros Pendientes</span>
              <div class="count"><?= $cliente->totales["ret_pendientes"]?></div>
            </div>
            
            <!--
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
              <div class="count">7,325</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            -->
            
          </div>
          <!-- /top tiles -->
          
          
          
          <!--
        <div class="row">
         
          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <i class="fa fa-dollar"></i>
              <div class="count"><?php echo $cliente->gananciasInversion; ?></div>
              <div class="title">Mis Ganancias Por Inversion</div>
            </div>
          </div>

          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <i class="fa fa-dollar"></i>
              <div class="count"><?php echo $cliente->gananciasReferidos; ?></div>
              <div class="title">Mis Ganancias Por Referidos</div>
            </div>
          </div>


          <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <div class="info-box dark-bg">
              <i class="fa fa-dollar"></i>
              <div class="count"><?php echo ($cliente->gananciasInversion + $cliente->gananciasReferidos); ?></div>
              <div class="title">Total Mis Ganancias</div>
            </div>
          </div>


        </div>
        /.row-->


       
          <br>
          <div class="row" style="text-align: center;"> 
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <!-- <h2>Pie Graph Chart <small>Sessions</small></h2> -->
                    
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content" style="float: right">
                    <canvas id="myChart" width="400" height="280"></canvas>
                  </div>
                </div>
              </div>
          </div>
       



      </section>
      <div class="text-right">
        <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
         
          <a href="javascript:;">Derechos reservados - 2018</a> -->
        </div>
      </div>
    </div>
    </section>
    <!--main content end-->
  </section>
  <!-- container section start -->

  
  
  
  <!-- Modal -->
<div id="modalClient" class="modal fade"  role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #262b2d;">
        <form  id="form_modal" name="form_modal" onsubmit="return false;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" name="modal-title" id="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body" id="modal-body" name="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer" id="modal-footer" name="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
        </form>
    </div>

  </div>
</div>
  
  
  
  
  <!-- javascripts -->
  <script src="../client/js/jquery-3.3.1.min.js"></script>
  <script src="../client/js/jquery-ui-1.10.4.min.js"></script>
  <script type="../client/text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
  <!-- bootstrap -->
  <script src="../client/js/bootstrap.min.js"></script>
  <!-- nice scroll -->
  <script src="../client/js/jquery.scrollTo.min.js"></script>
  <script src="../client/js/jquery.nicescroll.js" type="text/javascript"></script>
  <!-- charts scripts -->
  <script src="../client/assets/jquery-knob/js/jquery.knob.js"></script>
  <script src="../client/js/jquery.sparkline.js" type="text/javascript"></script>
  <script src="../client/assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
  <script src="../client/js/owl.carousel.js"></script>
  <!-- jQuery full calendar -->
  <<script src="../client/js/fullcalendar.min.js"></script>
    <!-- Full Google Calendar - Calendar -->
    <script src="../client/assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="../client/js/calendar-custom.js"></script>
    <script src="../client/js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="../client/js/jquery.customSelect.min.js"></script>
    <script src="../client/assets/chart-master/Chart.js"></script>

    <!--custome script for all page-->
    <script src="../client/js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="../client/js/sparkline-chart.js"></script>
    <script src="../client/js/easy-pie-chart.js"></script>
    <script src="../client/js/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../client/js/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../client/js/xcharts.min.js"></script>
    <script src="../client/js/jquery.autosize.min.js"></script>
    <script src="../client/js/jquery.placeholder.min.js"></script>
    <script src="../client/js/gdp-data.js"></script>
    <script src="../client/js/morris.min.js"></script>
    <script src="../client/js/sparklines.js"></script>
    <script src="../client/js/charts.js"></script>
    <script src="../client/js/jquery.slimscroll.min.js"></script>
    <script src="../client/js/clientes.js?v=<?php echo time();?>"></script>
    <script src="js/admin.js?v=<?php echo time();?>"></script>
    <script src="../client/js/sweetalert.min.js"></script>
    <script src="../client/js/bootstrap-select.js"></script>
    <script src="../../js/datatables.js"></script>
    <script src="js/Chart.js"></script>
    <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw': function() {
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
        $("#owl-slider").owlCarousel({
          navigation: true,
          slideSpeed: 300,
          paginationSpeed: 400,
          singleItem: true

        });
      });

      //custom select box

      $(function() {
        $('select.styled').customSelect();
      });

      /* ---------- Map ---------- */
      $(function() {
        $('#map').vectorMap({
          map: 'world_mill_en',
          series: {
            regions: [{
              values: gdpData,
              scale: ['#000', '#000'],
              normalizeFunction: 'polynomial'
            }]
          },
          backgroundColor: '#eef3f7',
          onLabelShow: function(e, el, code) {
            el.html(el.html() + ' (GDP - ' + gdpData[code] + ')');
          }
        });
      });
    </script>
    
    
    <?php
        //$cliente->consultarTotalesGanancias();
    ?>
    
    <script>
        

function addCommas(nStr)
{
    return nStr;
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Total Ganancias", "Ganancias Paquetes", "Ganancias Referidos", "Ganancias Pagadas", "Ganancias Sin Pagar", "Total Inversiones"],
        datasets: [{
            label: 'Valores',
            data: ['<?= ($cliente->totales["tot_gan_paq"] + $cliente->totales["tot_gan_referidos"])?>', '<?= $cliente->totales["tot_gan_paq"]?>', '<?= $cliente->totales["tot_gan_referidos"]?>', '<?= $cliente->totales["tot_pagado"]?>', '<?= $cliente->totales["tot_pendiente"]?>', '<?= $cliente->totales["tot_invertido"]?>'],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        tooltips: {
            tooltipTemplate: "<%= addCommas(value) %>"
       }
    }
    
});


</script>

</body>

</html>
