
<?php 
$root="";
if(!file_exists("css/style.css")){
    $root = "../";
}
?>
</main>
    </div>
    <script type="text/javascript" src="<?= $root ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/jquery-migrate.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/jquery.form.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/jquery.mobile.custom.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/modernizr.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/response.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/swiper.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/waypoints.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/jquery.stellar.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/module.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= $root ?>js/sweetalert.min.js"></script>
    <script src="<?= $root ?>js/wow.min.js"></script>
    <script>
		new WOW().init();
		</script>
    
  </body>
</html>
