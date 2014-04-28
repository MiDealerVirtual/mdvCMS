<?php defined( 'ALLOWED_IP_CHECKING' ) OR exit( 'No direct script access allowed' );
//echo "<!-- test -->";
// check to see if it is a google bot
function isGoogleBot( $ip ) {
    // early return
    if( empty( $ip ) ) {
        return FALSE;
    }

    $host = gethostbyaddr( $ip );
    return strpos( $host, "googlebot.com" ) === FALSE ? FALSE : TRUE;
}

// first IP check (based on certain ranges)
function firstIpCheck( $ip ) {
    // allowed pr ip ranges (casted to LONG)
    $castedRanges = array(
        array( 405372928, 405405695 ),
        array( 405405696, 405422079 ),
        array( 405848064, 405864447 ),
        array( 405979136, 405995519 ),
        array( 406241280, 406257663 ),
        array( 406274048, 406290431 ),
        array( 406298624, 406306815 ),
        array( 411688960, 411697151 ),
        array( 411746304, 411762687 ),
        array( 411779072, 411795455 ),
        array( 411795456, 411828223 ),
        array( 412946432, 412950527 ),
        array( 413908992, 413925375 ),
        array( 417529856, 417538047 ),
        array( 1065611264, 1065615359 ),
        array( 1065873408, 1065877503 ),
        array( 1079574528, 1079578623 ),
        array( 1079623680, 1079627775 ),
        array( 1085456384, 1085464575 ),
        array( 1085915136, 1085923327 ),
        array( 1089306624, 1089339391 ),
        array( 1089970176, 1089974271 ),
        array( 1092075520, 1092091903 ),
        array( 1093058560, 1093066751 ),
        array( 1110573056, 1110638591 ),
        array( 1115791360, 1115795455 ),
        array( 1122476032, 1122480127 ),
        array( 1137426432, 1137442815 ),
        array( 1137623040, 1137639423 ),
        array( 1138786304, 1138819071 ),
        array( 1176731648, 1176735743 ),
        array( 1177354240, 1177419775 ),
        array( 1211236352, 1211269119 ),
        array( 1255489536, 1255505919 ),
        array( 1279848448, 1279852543 ),
        array( 1280098304, 1280102399 ),
        array( 2261385216, 2261450751 ),
        array( 2291204096, 2291269631 ),
        array( 2754215936, 2754281471 ),
        array( 2916319232, 2916335615 ),
        array( 2916581376, 2916614143 ),
        array( 2917449728, 2917466111 ),
        array( 2918404096, 2918408191 ),
        array( 3093233664, 3093237759 ),
        array( 3289161728, 3289169919 ),
        array( 3290181632, 3290185727 ),
        array( 3290464256, 3290472447 ),
        array( 3291086848, 3291103231 ),
        array( 3337895936, 3337900031 ),
        array( 3337969664, 3337973759 ),
        array( 3358720000, 3358728191 ),
        array( 3472375808, 3472392191 ),
        array( 3482775552, 3482779647 ),
        array( 3483791360, 3483795455 ),
        array( 3486285824, 3486302207 ),
        array( 3493244928, 3493249023 ),
        array( 3512451072, 3512467455 )
    );

    // loop through ranges and perform checks
    $ip        = ip2long( $ip );
    $isValidIp = FALSE;
    foreach( $castedRanges as $range ) {
        if( $ip >= $range[0] && $ip <= $range[1] ) {
            $isValidIp = TRUE;
            break;
        }
    }

    // return verdict
    return $isValidIp;
}

// second IP check (based on 3rd party api)
function secondIpCheck( $ip ) {
    // variables required
    $ipApi     = "http://api.netimpact.com/qv1.php?key=3RETKDEPIrPZ5dQH&qt=geoip&d=json&q=";
    $ipJson    = json_decode( file_get_contents( $ipApi.$ip ), TRUE );
    $isValidIp = FALSE;

    // perform check
    if( $ipJson[2] == "Puerto Rico" || $ipJson[6] == "PR" ) {
        $isValidIp = TRUE;
    }

    // return verdict
    return $isValidIp;
}


// check to see if its a google bot
$ipToCheck = false ? $_SERVER['REMOTE_ADDR'] : "206.248.71.198";
if( !isGoogleBot( $ip ) ) {
    // not google bot, next check if they are in pr?
    if( !firstIpCheck( $ipToCheck ) ) {
        // failed first pr test, lets try second pr test
        if( !secondIpCheck( $ipToCheck ) ) {
            // failed second pr test
            header( 'HTTP/1.1 503 Service Temporarily Unavailable' );
            header( 'Status: 503 Service Temporarily Unavailable' );
            die( "Temporarily Unavailable" );
        }
    }
}
