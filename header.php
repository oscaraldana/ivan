<?php 
$root="";
if(!file_exists("css/style.css")){
    $root = "../";
}

echo "<pre>".__FILE__;

echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Wolves </title>
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
        <!-- Logo --> <a class="headerLogo smoothScroll" href="#"> <img src="images/wolf_.jpg" width="60px" >
        </a> </header>
      <!-- Sidebar -->
      <div class="sidebar">
        <nav class="mainMenu">
          <ul class="menu">
            <li> <a class="smoothScroll" href="#timeline-part" title="What Is Wolves?">
                    <i class="step icon-question size-24"></i><span class="text">What is Wolves?</span>
                </a> 
            </li>
            <li> <a class="smoothScroll" href="javascript:;" title="What Is Wolves?">
                    <i class="step icon-identification size-24"></i><span class="text">What is Wolves?</span>
                </a> 
            </li>
                  
                  
            <!-- <li> <a class="smoothScroll" href="#stastistical-part" title="Services"><i

                  class="icon-reciept-1 size-24"></i><span class="text">Services</span></a>
            </li>
            <li> <a class="smoothScroll" href="#testimonials-part" title="Testimonial"><i

                  class="step icon-thumbs-up size-24"></i><span class="text">Testimonial</span></a>
            </li>
            <li> <a class="smoothScroll" href="#featured-part" title="Top Featured"><i

                  class="step icon-bulleted-list size-24"></i><span class="text">Top
                  Featured</span></a> </li>
            <li> <a class="smoothScroll" href="#pricing-part" title="Pricing"><i

                  class="step icon-cogs size-24"></i><span class="text">Pricing</span></a>
            </li>
            <li> <a class="smoothScroll" href="#membership-part" title="Get a home"><i

                  class="step icon-door-key size-24"></i><span class="text">Get
                  a home</span></a> </li>
            <li> <a class="smoothScroll" href="#tips-part" title="Important Tips"><i

                  class="step icon-light-bulb size-24"></i><span class="text">Important
                  Tips</span></a> </li>
            <li> <a class="smoothScroll" href="#events-part" title="Upcoming Events"><i

                  class="step icon-calendar-1 size-24 size"></i><span class="text">Upcoming
                  Events</span></a> </li>
            -->
            <li> <a class="smoothScroll" href="#contact-form" title="Contact Form"><i class="step icon-envelope-1 size-24"></i><span class="text">Contact</span></a>
            </li>
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
        
            
      