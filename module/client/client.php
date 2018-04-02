<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
error_reporting(E_ERROR);

require_once '../conf/sesion.php';
require_once '../conf/conf.php';
require_once '../connection/conex.php';

$_SESSION["clientId"] = 1;

$conex = WolfConex::conex();

//$dao = new clientDAO();


?>

<?php 

if ( !isset($_SESSION["clientId"]) || ( isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) ) ) { 
include_once '../header_only.php';    
    ?> 
<link href="../css/client.css" rel="stylesheet" id="client-css">

<!------ Include the above in your HEAD tag ---------->
<br>
<span style="float: right; margin-right: 20px;"><a href="../">Volver</a></span>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title"><?= $lang["client_login_tittle"] ?></h1>
            <div class="account-wall">
                <img class="profile-img" src="../images/wolf_.jpg"
                    alt="">
                <form class="form-signin">
                <input type="text" class="form-control" placeholder="<?= $lang["login_user"] ?>" required autofocus>
                <input type="password" class="form-control" placeholder="<?= $lang["login_passwd"] ?>" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit"><?= $lang["login_entrar"] ?></button>
                <!--<label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span> -->
                </form>
            </div>
            <a href="javascript:;" onclick="" class="text-center new-account"><?= $lang["login_registro"] ?></a>
        </div>
    </div>
</div>

<?php } else {
    
    $menu = '<li> <a class="smoothScroll" href="#timeline-part" title="What Is Wolves?">
                    <i class="step icon-question size-24"></i><span class="text">What is Wolves?</span>
                </a> 
            </li>';
    
    include_once '../header.php';    
    ?>

    


    <ul class="nav navbar-nav navbar-right" >
        <!-- <li><p class="navbar-text">Already have an account?</p></li> -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Ivan</b> <span class="caret"></span></a>
            <ul id="login-dp" class="dropdown-menu">
                <li>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-buttons">
                               <a href="#" class="btn btn-fb">Cerrar Sesion</a>
                                <!-- <href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a> -->
                            </div>
                        </div>
                        <div class="bottom text-center">
                            New here ? <a href="#"><b>Join Us</b></a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
      </ul>
    <?php
} ?>

<script type="text/javascript" src="../js/client.js"></script>
<script src="js/jquery-ui-1.10.4.min.js"></script>


<?php
 session_destroy();
include_once '../footer.php';
