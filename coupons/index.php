<?php
	$defaultCoupon = 100;
	if ( isset( $_GET["amt"] ) && $_GET["amt"] == 200 ) {
		$defaultCoupon = 200;	
	}
	if ( isset( $_GET["date"] ) ) {
		$date = $_GET["date"];	
	}
	if ( isset( $_GET["time"] ) ) {
		$time = $_GET["time"];	
	}
?>
<!DOCTYPE html>
<html>
<head>
	<!-- open meta data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0 " />
    <!-- close meta data -->
    
    <!-- open page title -->
    <title>Certificado de $<?=$defaultCoupon?> | Cabrera Auto Mall en Arecibo, Puerto Rico 00614  &mdash; Buick, Cadillac, Chevrolet, Chrysler, Dodge, Ford, GMC, Jeep, Suzuki, Mazda, Mitsubishi, Nissan &mdash; Sirviendo a Hatillo, Isabela y Todo Puerto Rico</title>
    <!-- close page title -->
    
    <!-- open/close favicon -->
    <link href="http://cabreraauto.com/addons/default/themes/mdv_theme_23/img/favicon.ico" rel="shortcut icon" type="image/x-icon" />
    
    <!-- open styles -->
    <style>
	.top-instruction {
		display:block;
		float:left;
		padding-bottom:25px;
	}
	.bottom-instruction {
		display:block;
		float:left;
		padding-top:25px;
		clear:left;
	}
	.coupon-bg {
		position:relative;	
		display:block;
		width:602px;
		height:568px;
		/*background:url(cabrera-auto-coupon-<?=$defaultCoupon?>.png);*/
		float:left;
		top:0px;
		margin:0px;
		padding:0 0 30px 0;
		clear:left;
	}
	.coupon-bg .coupon-text {
		position:relative;
		top:306px;
		width:602px;
		text-align:center;
		font-family:Helvetica, Arial, sans-serif;
		font-weight:bold;
	}
	</style>
    <!-- close styles -->
</head>
<body>

    <!-- top options -->
    <div class="top-instruction">
    <a href="http://cabreraauto.com/inicio" title="Dealer Virtual de Cabrera Auto Mall | Cabrera Auto Mall en Arecibo, Puerto Rico 00614  &mdash; Buick, Cadillac, Chevrolet, Chrysler, Dodge, Ford, GMC, Jeep, Suzuki, Mazda, Mitsubishi, Nissan &mdash; Sirviendo a Hatillo, Isabela y Todo Puerto Rico">Regresar</a> | <a href="#" onClick="window.print(); return false;">Imprimir</a>
    </div>
    
    <!-- show coupon image -->
    <div class="coupon-bg">
<?php
	if ( isset( $date ) && isset( $time ) ) {
?>
        <div class="coupon-text">Cita para el <?=$date?> a las <?=$time?></div>
<?php
	}
?>
        <img src="cabrera-auto-coupon-<?=$defaultCoupon?>.png" alt="$<?=$defaultCoupon?> Coupon Certificate" style="float:left; clear:both;" />
    </div>
    
    <!-- bottom options -->
    <div class="bottom-instruction">
    <a href="http://cabreraauto.com/inicio" title="Dealer Virtual de Cabrera Auto Mall | Cabrera Auto Mall en Arecibo, Puerto Rico 00614  &mdash; Buick, Cadillac, Chevrolet, Chrysler, Dodge, Ford, GMC, Jeep, Suzuki, Mazda, Mitsubishi, Nissan &mdash; Sirviendo a Hatillo, Isabela y Todo Puerto Rico">Regresar</a> | <a href="#" onClick="window.print(); return false;">Imprimir</a>
    </div>
    
    <!-- open google analytics script -->
	<script type="text/javascript">
    
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-36248249-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    
    </script>
    <!-- close google analytics script -->
</body>
</html>