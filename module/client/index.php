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
include_once '../../header_only.php';    
    ?> 
<!-- Bootstrap CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  
  
<link href="../../css/client.css" rel="stylesheet" id="client-css">

<style>
    body{
        background-color: #262b2d;
    }
</style>

<!------ Include the above in your HEAD tag ---------->
<br>
<span style="float: right; margin-right: 20px;"><a href="../">Volver</a></span>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?= $lang["client_login_tittle"] ?></h1>
            <div class="account-wall">
                <img class="profile-img" src="../../images/wolf_.jpg"
                    alt="">
                <form class="form-signin" onsubmit="login(); return false;">
                    <input type="text" id="user_login" name="user_login" required="" class="form-control" placeholder="<?= $lang["login_user"] ?>" autofocus>
                    <input type="password"  id="pass_login"  name="pass_login" required="" class="form-control" placeholder="<?= $lang["login_passwd"] ?>" >
                <button class="btn btn-lg btn-primary btn-block" ><?= $lang["login_entrar"] ?></button>
                <!--<label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span> -->
                </form>
            </div>
            <a href="javascript:;" onclick="registro()" class="text-center new-account"><?= $lang["login_registro"] ?></a>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="modalBuy" class="modal fade"  role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="background-color: #262b2d;">
        <form onsubmit='aceptarRegistro(); return false;' id="form_registro" name="form_registro">
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


<script src="js/clientes.js"></script>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<?php } else {

    include_once './dashboard.php';
    
}