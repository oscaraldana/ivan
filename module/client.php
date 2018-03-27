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


$conex = WolfConex::conex();

include_once '../header.php';

?>

<link href="../css/client.css" rel="stylesheet" id="client-css">

<?php 

if ( !isset($_SESSION["clientId"]) || ( isset($_SESSION["clientId"]) && empty($_SESSION["clientId"]) ) ) { ?> 
<!------ Include the above in your HEAD tag ---------->
<br>
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
            <a href="javascript:;" class="text-center new-account"><?= $lang["login_registro"] ?></a>
        </div>
    </div>
</div>

<?php } ?>
<?php
include_once '../footer.php';
