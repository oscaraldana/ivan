<?php



//error_reporting(E_ERROR);
//$root = "../";
require_once '../../conf/sesion.php';
require_once '../../conf/conf.php';
require_once '../../connection/conex.php';

//$_SESSION["clientId"] = 1;

$conex = WolfConex::conex();

//session_destroy();


?>

<?php 

if ( !isset($_SESSION["clientId"]) || ( isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) ) ) {
//include_once '../../header_only.php';    
    ?> 
<!-- Bootstrap CSS 
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
  
<link href="../../css/client.css" rel="stylesheet" id="client-css">
-->

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <!-- font icon -->
  <link href="css/elegant-icons-style.css" rel="stylesheet" />
  <link href="css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet" />


<style>
    body{
        background-color: #262b2d;
    }
    
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
           
           
/* Radio button */
.radiobtn {
  display: none;
}
.buttons {
  margin-left: -40px;
}
.buttons li {
    padding-left: 30px;
  display: block;
}
.buttons li label{
  padding-left: 30px;
  position: relative;
  left: -25px;
}
.buttons li label:hover {
  cursor: pointer;
}
.buttons li span {
  display: inline-block;
  position: relative;
  top: 5px;
  border: 2px solid #999;
  width: 18px;
  height: 18px;
  background: #fff;
}
.radiobtn:checked + span::before{
  content: '';
  border: 2px solid #fff;
  position: absolute;
  width: 14px;
  height: 14px;
  background-color:  #2b58c0;
}   
           
</style>


<div class="container">
<br><br><span style="float: right; margin-right: 20px;"><a href="../">Volver</a></span>
<br><br>
<h3 class="text-center login-title"><?= $lang["client_login_tittle"] ?></h3>
    <form class="login-form" onsubmit="login(); return false;">
      <div class="login-wrap">
        <p class="login-img"><i class="icon_lock_alt"></i></p>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_profile"></i></span>
          <input type="text" class="form-control" placeholder="Usuario" autofocus id="user_login" name="user_login" required="true">
        </div>
        <div class="input-group">
          <span class="input-group-addon"><i class="icon_key_alt"></i></span>
          <input type="password" class="form-control" placeholder="Contrase&ntilde;a" id="pass_login" name="pass_login" required="true">
        </div>
        <label class="checkbox">
                <!-- <input type="checkbox" value="remember-me"> Remember me -->
            <span class="pull-right"><a href="javascript:;" class="btn-link" onclick="formOlvidoClave();">&iquest;Olvido su contrase&ntilde;a?</a></span>
            </label>
        <br>
        <button class="btn btn-logg btn-lg btn-block" type="submit">Ingresar</button>
        <p class="btn btn-regg btn-lg btn-block" onclick="registro()">Registrarme</p>
      </div>
    </form>
    <div class="text-right">
      <div class="credits">
          <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version form: https://bootstrapmade.com/buy/?theme=NiceAdmin
          
          <a href="javascript:;">Derechos reservados</a>
          -->
        </div>
    </div>
  </div>





<!--
<br>
<span style="float: right; margin-right: 20px;"><a href="../">Volver</a></span>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?= $lang["client_login_tittle"] ?></h1>
            <div class="account-wall">
                <img class="profile-img" src="../../images/wolvess.jpeg"  alt="">
                <form class="form-signin" onsubmit="login(); return false;">
                    <input type="text" id="user_login" name="user_login" required="" class="form-control" placeholder="<?= $lang["login_user"] ?>" autofocus>
                    <input type="password"  id="pass_login"  name="pass_login" required="" class="form-control" placeholder="<?= $lang["login_passwd"] ?>" >
                <button class="btn btn-lg btn-primary btn-block" ><?= $lang["login_entrar"] ?></button>
                
                </form>
            </div>
            <span width="100%" style="border: #ffff33 ">¿No tienes una cuenta?</span> <a href="javascript:;" onclick="registro()" class="right text-right bg-primary">Registrate</a>
        </div>
    </div>
</div>
-->

<!-- Modal -->
<div id="modalBuy" class="modal fade"  role="dialog" style="display: none">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #262b2d;">
        <form id="form_registro" name="form_registro" method="post" enctype="multipart/form-data"
            action="controller.php"
            target="iframeUpload">
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




<!-- Modal -->
<div id="modalx" class="modal fade"  role="dialog" style="display: none">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #262b2d;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" name="modal-titlex" id="modal-titlex">Modal Header</h4>
      </div>
      <div class="modal-body" id="modal-bodyx" name="modal-bodyx">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer" id="modal-footerx" name="modal-footerx">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<style>
    
    
    
</style>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/clientes.js"></script>
<script src="js/sweetalert.min.js"></script>

<?php } else {

    include_once './dashboard.php';
    
}