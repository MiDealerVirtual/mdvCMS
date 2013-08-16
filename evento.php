<?php
    // script constants
    define( "ACCEPTABLE_URL", "http://cabreraauto.com/evento" );
    define( "EMAIL_TO",       "jose.vega@cabreraauto.com" );
    define( "EMAIL_FROM",     "facebook.event@cabreraauto.com" );
    define( "EMAIL_SUBJECT",  "Cabreraauto.com FB Event Registration" );

    // set correct timezone
    date_default_timezone_set( 'America/Puerto_Rico' );

    // restrict usage
    if( $_SERVER['HTTP_REFERER'] === ACCEPTABLE_URL && array_key_exists( 'k', $_GET ) ) {
        // quick validation
        $reqs    = array( 'fname' => 'Nombre', 'lname' => 'Apellido', 'telephone' => 'Número telefónico', 'email' => 'Correo electrónico', 'day' => 'Fecha de nacimiento [dia]', 'month' => 'Fecha de nacimiento [mes]',/* 'year' => 'Fecha de nacimiento [año]',*/ 'city' => 'Pueblo', 'vehicle_interested' => 'Preferencia de autos' );
        $valid   = TRUE;
        $message = "";
        foreach( $reqs as $k => $v ) {
            // trim them first
            $_POST[$k] = trim( $_POST[$k] );

            // validate each field
            if( !in_array( $k, array_keys( $_POST ) ) || strlen( $_POST[$k] ) == 0 ) {
                $valid = FALSE;
            } else {
                $message .= $v.": ".$_POST[$k]."\n\n";
            }
        }

        // send success email
        if( $valid ) {
            // create extra data
            $regDate      = date( 'd/m/Y' );
            $regTime      = date( 'H:i:s' );
            $ticketNumber = substr( sha1( date( 'Y-m-d H:i:s' ) ), 0, 10 );

            // extend message
            $message .= "Fecha: ".$regDate."\n\n".
                        "Hora: ".$regTime."\n\n".
                        "Num. de Boleto: ".$ticketNumber."\n\n";

            // prepare email data
            $to      = EMAIL_TO;
            $subject = EMAIL_SUBJECT;
            $message = ( strlen( $message ) > 0 ) ? $message : "A new FB event registration occured.";
            $from    = EMAIL_FROM;
            $headers = "From:" . $from;
            if( true || mail( $to, $subject, $message, $headers ) ) {
                $submitted = TRUE;
            }
            // email failed to send (redirect back to event form page )
            else {
                header( "Location:".ACCEPTABLE_URL."?error=failed+email" );    
            }
        }
        // missing fields (redirect back to event form page )
        else {
            header( "Location:".ACCEPTABLE_URL."?error=missing+fields" );
        }
    }
    // not an authorized referrer or missing random key (redirect back to event form page )
    else {
        header( "Location:".ACCEPTABLE_URL );
    }

    // determine if we proceed to show printable coupon
    if( $submitted ) {
?>
<!DOCTYPE html>
<html>
<head>
    <!-- open meta data -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0 " />
    <!-- close meta data -->
    
    <!-- open page title -->
    <title>FB Fan Appreciation Event Registration | Cabrera Auto Mall en Arecibo, Puerto Rico 00614  &mdash; Buick, Cadillac, Chevrolet, Chrysler, Dodge, Ford, GMC, Jeep, Suzuki, Mazda, Mitsubishi, Nissan &mdash; Sirviendo a Hatillo, Isabela y Todo Puerto Rico</title>
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
        width:440px;
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
        top:435px;
        width:440px;
        text-align:center;
        font-family:Helvetica, Arial, sans-serif;
        font-weight:bold;
    }
    .coupon-bg .coupon-text-2 {
        position:relative;
        top:450px;
        width:440px;
        text-align:center;
        font-family:Helvetica, Arial, sans-serif;
        font-size: 12px;
    }
    .coupon-bg .coupon-text-3 {
        position:relative;
        top:530px;
        width:440px;
        text-align:center;
        font-family:Helvetica, Arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
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
        <div class="coupon-text"><?=implode( ' ', array( $_POST['fname'], $_POST['lname'] ) ); ?></div>
        <div class="coupon-text-2"><?='&lt;&nbsp;'.implode( '&nbsp;&gt;&nbsp;&nbsp;&nbsp;&lt;&nbsp;', array( $_POST['telephone'], $_POST['email'], $_POST['city'] ) ).'&nbsp;&gt;'; ?></div>
        <div class="coupon-text-3">Registrado el <?=$regDate?> a las <?=$regTime?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ticket #: <?=$ticketNumber?></div>
        <img src="/coupons/cabrera-auto-fb-event.png" alt="FB Fan Appreciation Event Registration" style="float:left; clear:both;" />
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
<?
    }