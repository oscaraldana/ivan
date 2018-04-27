<?php 
$root="";
if(!file_exists("css/style.css")){
    $root = "../";
}

?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Type" content="text/html; ISO-8859-1">
    <META NAME="DC.Language" SCHEME="RFC1766" CONTENT="Spanish">
    <META NAME="AUTHOR" CONTENT="ivan contreras">
    <META NAME="REPLY-TO" CONTENT="oealdana@gmail.com">
    <LINK REV="made" href="mailto:oealdana@gmail.com">
    <META NAME="DESCRIPTION" CONTENT="Sitio de inversion con ganancias mensuales my rentables">
    <META NAME="KEYWORDS" CONTENT="wolves,trader,company,trading,wolf,bitcoin,dolares,ganancias,rentabilidad">
    <META NAME="Resource-type" CONTENT="Homepage">
    <META NAME="DateCreated" CONTENT="Mon, 30 April 2018 00:00:00 GMT+1">
    <META NAME="robots" content="ALL">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Wolves Traders Company </title>
    <link rel="shortcut icon" type="image/x-icon" href="/images/wolves.ico" />
    <!-- Windows 8 Tiles -->
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <!-- ****** faviconit.com favicons ****** -->
    <link rel="stylesheet" type="text/css" href="<?= $root ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?= $root ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= $root ?>css/animate.min.css">
    <link rel="stylesheet" href="<?= $root ?>css/picto-foundry-emotions.css">
    <link rel="stylesheet" href="<?= $root ?>css/picto-foundry-household.css">
    <link rel="stylesheet" href="<?= $root ?>css/picto-foundry-shopping-finance.css">
    <link rel="stylesheet" href="<?= $root ?>css/picto-foundry-general.css">
    <link href="<?= $root ?>css/font-awesome.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="pushWrapper">
      <!-- Header (shown on mobile only) -->
      <header class="pageHeader">
        <!-- Menu Trigger --> <button class="menu-trigger"> <span class="lines"></span>
        </button>
        <!-- Logo --><a class="headerLogo smoothScroll" href="#"> <img src="images/wolvess.jpeg" width="60px" >
        </a> </header>
      <!-- Sidebar -->
       <div class="sidebar">
        <nav class="mainMenu">
          <ul class="menu">
            
            <?php
            
            if ( isset($menu) && !empty($menu) ){
                echo $menu;
            }
            else { ?>
            
            <li> <a class="smoothScroll" href="#timeline-part" title="¿Quienes Somos?">
                    <i class="step icon-question size-24"></i><span class="text">¿Quienes Somos?</span>
                </a> 
            </li>
            <li> <a class="smoothScroll" href="#testimonials-part" title="Testimonios">
                    <i class="step icon-thumbs-up size-24"></i><span class="text">Testimonios</span></a>
            </li>
            <li> <a class="smoothScroll" href="#tips-part" title="Tips Importantes">
                    <i class="step icon-light-bulb size-24"></i><span class="text">Tips Importantes</span></a> </li>
            <li> <a class="smoothScroll" href="module/client/" title="">
                    <i class="step icon-identification size-24"></i><span class="text">Registrarme</span>
                </a> 
            </li>
            <li> <a class="smoothScroll" href="#contact-form" title="Contact Form"><i class="step icon-envelope-1 size-24"></i><span class="text">Contact</span></a>
            </li>      
            <?php } ?>
                  
            
          </ul>
        </nav>
        <nav class="backToTop">
          <ul class="backToTop-menu">
            <li><a class="smoothScroll" href="#section-intro" title="to the top"><i

                  class="fa fa-chevron-up"></i><span class="text">Back to top</span></a></li>
          </ul>
        </nav>
      </div>
      
      
      <!-- Share Menu -->
      <!--
      <nav class="shareMenu"> <a href="#" class="share-menu-trigger"><i class="fa fa-share-alt"></i></a>
        <div class="tweet-share">
          <!-- Facebook - ADD HERE -->
          <!-- Twitter - ADD HERE -->
          <!-- <a href="https://twitter.com/share" class="twitter-share-button"

            data-via="TaphaNgum">Tweet</a>
          <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        </div>
      </nav>
      -->
      
      <!-- Main -->
      <main id="mainContent" name="mainContent">
        <!-- FORMS -->
        <!-- INTRO -->
        
            
      