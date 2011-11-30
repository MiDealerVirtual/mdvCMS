<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* MDV CMS Helpers
*
* @package		mdvCMS
* @subpackage	Helpers
* @category		Helpers
* @author       Joze Perez - mdvCMS Dev Team
*/

// ------------------------------------------------------------------------

function varsToExtract()
{
	return array(
			array( 'base_url', '{pyro:url:site}' ),
			array( 'mdv_ids', '{pyro:variables:mdv_ids}' ),
			array( 'mdv_inv_seo', '{pyro:variables:mdv_inv_seo}', true ),
			array( 'mdv_form_options', '{pyro:variables:mdv_form_options}', true ),
			array( 'page_title_seo_suffix', '{pyro:variables:page_title_seo_suffix}' ),
			array( 'dealer_name', '{pyro:variables:dealer_inc_name}' ),
			array( 'inventory_page_keywords', '{pyro:variables:inventory_page_keywords}' ),
			array( 'max_similar', '{pyro:variables:vehicle_page_max_similar}' ),
			);
}

function parseStringForURL( $string )
{
	$string = ucwords( strtolower( $string ) );
	$string = str_replace( ' ', '-', $string );
	$string = str_replace( ',', '', $string );
	$string = str_replace( '/', '', $string );
	return $string;
}

function createVehiclePermaLink( $cms_vars, $args /* $ci, $mk, $md, $tr, $yr, $vn */ )
{
	// initiate url
	$url_to_return = "";
	
	// determine suffix
	if( is_array( $cms_vars['mdv_inv_seo'] ) && count( $cms_vars['mdv_inv_seo'] ) > 1 && isset( $cms_vars['mdv_inv_seo'][$args['ci']] ) )
		$url_to_return .= $cms_vars['mdv_inv_seo'][$args['ci']]."/";
	
	// finish url (assume vin is there )
	$url_to_return .= strtolower( $args['mk'].'-'.parseStringForURL( $args['md'] ).'-'. ( ( $args['tr'] != '' ) ? parseStringForURL( $args['tr'] ).'-' : '' ) .$args['yr'].'-'.$args['vn'] );
	
	// return
	return $url_to_return;
}

function getVehicleLink( $v, $slug, $cms_vars )
{
	return $slug."/".createVehiclePermaLink( $cms_vars,
											  array( 'ci' => $v->CLIENT_ID,
											  		 'mk' => $v->MAKE,
													 'md' => $v->MODEL,
													 'tr' => $v->TRIM,
													 'yr' => $v->YEAR,
													 'vn' => substr( $v->VIN, ( strlen( $v->VIN ) - 3 ) )
											) );
}

function getVehicleLabel( $v )
{
	return $v->MAKE." ".$v->MODEL.( ( $v->TRIM != "" ) ? " ".$v->TRIM : "" )." ".$v->YEAR;
}

function getVehicleImagePath( $config, $v, $image_type, $prefix )
{
	return $config->item( 'images_base_url' ).$config->item( ( $v->IOL_IMAGE == 1 ) ? 'iol_vehicle_pictures_'.$image_type.'_path' : 'vehicle_pictures_'.$image_type.'_path' ).$prefix.$v->IMAGE;	
}

function transalateVehicleAttr( &$v /* In / Out */ )
{
	// Transform condition
	switch( $v->CONDITION )
	{
		case "new": $v->CONDITION = "Nuevo"; break;
		case "used": $v->CONDITION = "Usado"; break;
		case "certified": $v->CONDITION = "Certificado"; break;
		default: $v->CONDITION = ucfirst( strtolower( $v->CONDITION ) );
	}
	
	// Transform transmission
	switch( $v->TRANSMISSION )
	{
		case "automatic": $v->TRANSMISSION = "Autom&aacute;tico"; break;
		case "manual": $v->TRANSMISSION = "Manual"; break;
		case "cvt": $v->TRANSMISSION = "Autom&aacute;tico"; break;
		default: $v->TRANSMISSION = ucfirst( strtolower( $v->TRANSMISSION ) );
	}
}

function translateNumber( $number, $floating_pos = 2 )
{
	// strip characters from number
	$number = str_replace( ",", "", $number );
	
	// return formated number
	return number_format( $number, $floating_pos, '.', ',' );	
}

function createVehicleMiniDetails( $v )
{
	if( $v->HIDE_PRICE == 0 ):
		echo '<div class="price"><strong>Precio:</strong> <span>$'.translateNumber( $v->PRICE ).'</span></div>';
	elseif( $v->PRICE_STRING != '' ):
		// Determine if string starts with "desde"
		if( strpos( $v->PRICE_STRING, "Desde" ) !== FALSE ):
			$new_price = str_replace( "Desde: ", "", $v->PRICE_STRING );
			$new_price = str_replace( "Hasta:", "-", $new_price );
			
			echo '<div class="price"><strong>Precio:</strong> <span>'.$new_price.'</span></div>';
		else:
			echo '<div class="price"><strong>Precio:</strong> <span>'.$v->PRICE_STRING.'</span></div>';
		endif;
	else:
		echo '<div class="price"><strong>Precio:</strong> <span>Llama hoy</span></div>';
	endif;	
}

/**
 * Functions that encapsulate Pyro Vars
 **/
 	
	// Extract Vars from CMS
	function extractVars( $vars_for_extraction = array() )
	{
		$vars_for_return = array();
		foreach( $vars_for_extraction as $v )
		{
			// fetch var
			if( isset( $v[2] ) && $v[2] == true )
				$vars_for_return[$v[0]] = processArrayVar( $v[1] );
			else
				$vars_for_return[$v[0]] = parseStr( $v[1] );
		}
		
		return $vars_for_return;
	}
	
	// Parse String
	function parseStr( $string )
	{
		// fetch CI
		$CI =& get_instance();
		
		// return parsed string
		return $CI->parser->parse_string( $string, array(), TRUE );
	}
	
	// Process Array Variable
	function processArrayVar( $string )
	{
		$temp_v = parseStr( $string );
		$temp_v = explode( "|", $temp_v );
		$temp_arr = array();
		
		foreach( $temp_v as $v )
		{
			$v = explode( "=>", $v );
			$temp_arr[$v[0]] = $v[1];	
		}
		
		return $temp_arr;
	}