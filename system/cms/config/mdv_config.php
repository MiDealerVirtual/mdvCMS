<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MDV Database Credentials
|--------------------------------------------------------------------------
|
| Username, Password, Database and Hostname
|
*/

$config['cms_db_prefix'] = 'default_';

/*
|--------------------------------------------------------------------------
| SEO Installation Config
|--------------------------------------------------------------------------
|
| All the customization needed for the SEO Installed CI version
|
*/
$config['perm_base_url'] = "http://midealervirtual.com/";
$config['images_base_url'] = "http://midealervirtual.com/";

/*
|--------------------------------------------------------------------------
| Directory Paths
|--------------------------------------------------------------------------
|
| List all the frequently used (directory) paths.
|
*/
$image_config         = json_decode(file_get_contents('/home1/mdv/image_server_flags.json'),true);
$config['library_path'] = "library/";
$config['js_path'] = $config['library_path']."js/";
$config['backend_js_path'] = $config['js_path']."back/";
$config['frontend_js_path'] = $config['js_path']."front/";
$config['css_path'] = $config['library_path']."css/";
$config['vehicle_pictures_path'] = 'vpics/';
$config['vehicle_pictures_web_path'] = $config['vehicle_pictures_path'].'web/';
$config['vehicle_pictures_med_path'] = $config['vehicle_pictures_path'].'med/';
$config['vehicle_pictures_thumb_path'] = $config['vehicle_pictures_path'].'thumb/';
$config['vehicle_pictures_tiny_path'] = $config['vehicle_pictures_path'].'tiny/';
$config['vehicle_pictures_profile_path'] = $config['vehicle_pictures_path'].'profile/';
$config['website_images_path'] = 'wpics/';
$config['website_images_logo_path'] = $config['website_images_path'].'logo/';
$config['website_images_collections_path'] = $config['website_images_path'].'collections/';
$config['website_images_pages_path'] = $config['website_images_path'].'pages/';
$config['website_images_groups_path'] = $config['website_images_path'].'groups/';

	$config['iol_vehicle_pictures_web_path'] = $config['vehicle_pictures_path'].'iol_imports/web/';
	$config['iol_vehicle_pictures_med_path'] = $config['vehicle_pictures_path'].'iol_imports/med/';
	$config['iol_vehicle_pictures_thumb_path'] = $config['vehicle_pictures_path'].'iol_imports/thumb/';
	$config['iol_vehicle_pictures_tiny_path'] = $config['vehicle_pictures_path'].'iol_imports/tiny/';

// Merge in the config
$config = array_merge( $config, $image_config );



// If we switch to S3
if( $config['S3_DOMAIN'] ) {
    // Vehicle paths
    $config['vehicle_pictures_path']           = $config['S3_PHP_PATH'];
    $config['vehicle_pictures_web_path']       = $config['S3_PHP_PATH'].'onsite/web/';
    $config['vehicle_pictures_med_path']       = $config['S3_PHP_PATH'].'onsite/med/';
    $config['vehicle_pictures_thumb_path']     = $config['S3_PHP_PATH'].'onsite/thumb/';
    $config['vehicle_pictures_tiny_path']      = $config['S3_PHP_PATH'].'onsite/tiny/';
    $config['vehicle_pictures_profile_path']   = $config['S3_PHP_PATH'].'onsite/profile/';

    // IOL paths
    $config['iol_vehicle_pictures_web_path']   = $config['S3_PHP_PATH'].'iol/web/';
    $config['iol_vehicle_pictures_med_path']   = $config['S3_PHP_PATH'].'iol/med/';
    $config['iol_vehicle_pictures_thumb_path'] = $config['S3_PHP_PATH'].'iol/thumb/';
    $config['iol_vehicle_pictures_tiny_path']  = $config['S3_PHP_PATH'].'iol/tiny/';

}

/*
|--------------------------------------------------------------------------
| jQuery Library to Load
|--------------------------------------------------------------------------
|
| Update the name of the file that is the current version of jQuery being used.
|
*/
$config['jquery'] = "jquery.1.4.2.js";

/*
|--------------------------------------------------------------------------
| Lightbox Images Path
|--------------------------------------------------------------------------
*/
$config['lightbox_path'] = $config['perm_base_url']."mdvcms_library/images/lightbox/";

/*
|--------------------------------------------------------------------------
| Special jQuery/Javascript Variables
|--------------------------------------------------------------------------
|
| A list of values of important variables.
|
*/
$config['js_url_prefix'] = "";	// "index.php/";

/*
|--------------------------------------------------------------------------
| Makes used in MDV.com
|--------------------------------------------------------------------------
|
| A List of all the makes that we have available.
|
*/
	// Setup temp array
	$makeArr = array();
	$mcount = 0;
		
		// First Option
		$makeArr[$mcount++] = "Seleccione";
		
		// A
		$makeArr[$mcount++] = "Acura";
			// $makeArr[$mcount++] = "Alfa Romeo";
		$makeArr[$mcount++] = "Audi";
		// B
		$makeArr[$mcount++] = "BMW";
		$makeArr[$mcount++] = "Buick";
		// C
		$makeArr[$mcount++] = "Cadillac";
		$makeArr[$mcount++] = "Chevrolet";
		$makeArr[$mcount++] = "Chrysler";
		// D
		$makeArr[$mcount++] = "Daewoo";
		$makeArr[$mcount++] = "Dodge";
		// E
			// $makeArr[$mcount++] = "Eagle";
		// F
		$makeArr[$mcount++] = "Ford";
		// G
			//$makeArr[$mcount++] = "Geo";
		$makeArr[$mcount++] = "GMC";
		// H
		$makeArr[$mcount++] = "Honda";
		$makeArr[$mcount++] = "HUMMER";
		$makeArr[$mcount++] = "Hyundai";
		// I
		$makeArr[$mcount++] = "Infiniti";
		$makeArr[$mcount++] = "International";
		$makeArr[$mcount++] = "Isuzu";
		// J
		$makeArr[$mcount++] = "Jaguar";
		$makeArr[$mcount++] = "Jeep";
		// K
		$makeArr[$mcount++] = "Kia";
		// K
		$makeArr[$mcount++] = "Land Rover";
		$makeArr[$mcount++] = "Lexus";
		$makeArr[$mcount++] = "Lincoln";
		// M
		$makeArr[$mcount++] = "Mazda";
		$makeArr[$mcount++] = "Mercedes-Benz";
		$makeArr[$mcount++] = "Mercury";
		$makeArr[$mcount++] = "MINI";
		$makeArr[$mcount++] = "Mitsubishi";
		// N
		$makeArr[$mcount++] = "Nissan";
		// O
		$makeArr[$mcount++] = "Oldsmobile";
		// P
		$makeArr[$mcount++] = "Plymouth";
		$makeArr[$mcount++] = "Pontiac";
		$makeArr[$mcount++] = "Porsche";
		// S
		$makeArr[$mcount++] = "Saab";
		$makeArr[$mcount++] = "Saturn";
		$makeArr[$mcount++] = "Scion";
		$makeArr[$mcount++] = "Subaru";
		$makeArr[$mcount++] = "Suzuki";
		// T
		$makeArr[$mcount++] = "Toyota";
		// V
		$makeArr[$mcount++] = "Volkswagen";
		$makeArr[$mcount++] = "Volvo";
		
	// Add to configurations
	$config['vehicle_makes'] = $makeArr;
	
	// Unset temp array
	unset( $makeArr );
	
/*
|--------------------------------------------------------------------------
| Year range used in MDV.com
|--------------------------------------------------------------------------
|
| Max year and min year used in MDV.com
|
*/
	$config['max_year'] = date( 'Y' ) + 1;
	$config['min_year'] = date( 'Y' ) - 20;
	
/*
|--------------------------------------------------------------------------
| Colors used in MDV.com
|--------------------------------------------------------------------------
|
| List of colors used in MDV.com
|
*/	
	// Setup temp array
	$colorsArr = array();
	$colorsArr[''] = 'Seleccione';
	$colorsArr['Amarillo'] = 'Amarillo';
	$colorsArr['Azul'] = 'Azul';
	$colorsArr['Baige'] = 'Baige';
	$colorsArr['Blanco'] = 'Blanco';
	$colorsArr['Cafe'] = 'Cafe';
	$colorsArr['Dorado'] = 'Dorado';
	$colorsArr['Gris'] = 'Gris';
	$colorsArr['Negro'] = 'Negro';
	$colorsArr['Plateado'] = 'Plateado';
	$colorsArr['Rojo'] = 'Rojo';
	$colorsArr['Rojo Vino'] = 'Rojo Vino';
	$colorsArr['Verde'] = 'Verde';
	
	// Add to configurations
	$config['vehicle_colors'] = $colorsArr;
	
/*
|--------------------------------------------------------------------------
| Image settings used in MDV.com
|--------------------------------------------------------------------------
|
| Image settings for uploaded images used in MDV.com
|
*/
	$config['web_max_dimension'] = 800;
	$config['med_max_dimension'] = 340;
	$config['thumb_max_dimension'] = 86;
	$config['tiny_max_dimension'] = 52;
	$config['max_number_of_images_per_vehicle'] = 20;
	
/*
|--------------------------------------------------------------------------
| Pagination settings for MDV.com
|--------------------------------------------------------------------------
|
| Pagination settings configuration. Will store information like maxperpage, wrapper, etc...
|
*/
	$config['front_end_max_per_page'] = 6;
	
/*
|--------------------------------------------------------------------------
| MDV Database Credentials
|--------------------------------------------------------------------------
|
| Username, Password, Database and Hostname
|
*/

$config['mdvdb_creds'] = array();
$config['mdvdb_creds']['dbdriver'] = "mysql";
$config['mdvdb_creds']['dbprefix'] = "";
$config['mdvdb_creds']['pconnect'] = TRUE;
$config['mdvdb_creds']['db_debug'] = TRUE;
$config['mdvdb_creds']['cache_on'] = FALSE;
$config['mdvdb_creds']['cachedir'] = "";
$config['mdvdb_creds']['char_set'] = "utf8";
$config['mdvdb_creds']['dbcollat'] = "utf8_general_ci";
$config['mdvdb_creds']['hostname'] = "localhost";
if ( false ) {
	// use legacy database for everything
	$config['mdvdb_creds']['hostname'] = '174.122.148.70';
	$config['mdvdb_creds']['username'] = 'mdv_dbroot';
	$config['mdvdb_creds']['password'] = 'MDVdbaccess';
	$config['mdvdb_creds']['database'] = 'mdv_iol_merger';
} else {
	// use local database only for inventory
	$config['mdvdb_creds']['username'] = 'mdv';
	$config['mdvdb_creds']['password'] = 'midealervirtual';
	$config['mdvdb_creds']['database'] = 'mdv_iol_cabrera';
	
	// use legacy database only for leads
	$config['mdvdb_leads_creds'] = $config['mdvdb_creds'];
	$config['mdvdb_leads_creds']['hostname'] = '174.122.148.70';
	$config['mdvdb_leads_creds']['username'] = 'mdv_dbroot';
	$config['mdvdb_leads_creds']['password'] = 'MDVdbaccess';
	$config['mdvdb_leads_creds']['database'] = 'mdv_iol_merger';
}
