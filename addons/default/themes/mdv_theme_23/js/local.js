/* Copyright (c) 2012 Mi Dealer Virtual and Joze Perez */

/**
 * Site error handling
 */
window.onerror = function( e ) {
	if ( typeof console == "object" && "log" in console ) {
		console.log( e );
	}
   return true;
};

/**
 * Cabrera make and models
 */
var models = {
	"Buick":		["Enclave", "Encore", "LaCrosse", "Regal", "Verano"],
	"Cadillac":		["ATS","CTS","Escalade","Escalade ESV","Escalade EXT","SRX","STS","XTS"],
	"Chevrolet":	["Avalanche","Camaro","Colorado Crew Cab","Colorado Extended Cab","Colorado Regular Cab","Corvette","Cruze","Equinox","Express 1500 Cargo","Express 1500 Passenger","Express 2500 Cargo","Express 2500 Passenger","Express 3500 Cargo","Express 3500 Passenger","Impala","Malibu","Silverado 1500 Crew Cab","Silverado 1500 Extended Cab","Silverado 1500 Regular Cab","Silverado 2500 HD Crew Cab","Silverado 2500 HD Extended Cab","Silverado 2500 HD Regular Cab","Silverado 3500 HD Crew Cab","Silverado 3500 HD Extended Cab","Silverado 3500 HD Regular Cab","Sonic","Spark","Suburban 1500","Suburban 2500","Tahoe","Traverse","Volt"],
	"Chrysler":		["200", "300", "Town & Country"],
	"Dodge":		["Avenger","Caliber","Challenger","Charger","Dart","Durango","Grand Caravan Cargo","Grand Caravan Passenger","Journey","Nitro"],
	"Ford":			["C-MAX Energi","C-MAX Hybrid","E150 Cargo","E150 Passenger","E250 Cargo","E350 Super Duty Cargo","E350 Super Duty Passenger","Edge","Escape","Expedition","Expedition EL","Explorer","F150 Regular Cab","F150 Super Cab","F150 SuperCrew Cab","F250 Super Duty Crew Cab","F250 Super Duty Regular Cab","F250 Super Duty Super Cab","F350 Super Duty Crew Cab","F350 Super Duty Regular Cab","F350 Super Duty Super Cab","F450 Super Duty Crew Cab","Fiesta","Flex","Focus","Focus ST","Fusion","Mustang","Ranger Regular Cab","Ranger Super Cab","Taurus","Transit Connect Cargo","Transit Connect Passenger"],
	"GMC":			["Acadia","Canyon Crew Cab","Canyon Extended Cab","Canyon Regular Cab","Savana 1500 Cargo","Savana 1500 Passenger","Savana 2500 Cargo","Savana 2500 Passenger","Savana 3500 Cargo","Savana 3500 Passenger","Sierra 1500 Crew Cab","Sierra 1500 Extended Cab","Sierra 1500 Regular Cab","Sierra 2500 HD Crew Cab","Sierra 2500 HD Extended Cab","Sierra 2500 HD Regular Cab","Sierra 3500 HD Crew Cab","Sierra 3500 HD Extended Cab","Sierra 3500 HD Regular Cab","Terrain","Yukon","Yukon XL 1500","Yukon XL 2500"],
	"Jeep":			["Compass","Grand Cherokee","Liberty","Patriot","Wrangler"],
	"Suzuki":		["Equator Crew Cab","Equator Extended Cab","Grand Vitara","Kizashi","SX4"],
	"Mazda":		["CX-5","CX-7","CX-9","MAZDA2","MAZDA3","MAZDA5","MAZDA6","Miata MX-5"],
	"Mitsubishi":	["Eclipse","Endeavor","Galant","i-MiEV","Lancer","Outlander","Outlander Sport"],
	"Nissan":		["370Z","Altima","Armada","cube","Frontier Crew Cab","Frontier King Cab","GT-R","JUKE","LEAF","Maxima","Murano","NV1500 Cargo","NV2500 HD Cargo","NV3500 HD Cargo","NV3500 HD Passenger","Pathfinder","Quest","Rogue","Sentra","Titan Crew Cab","Titan King Cab","Versa","Xterra"],
	"Ram":			["1500 Crew Cab", "1500 Quad Cab", "1500 Regular Cab", "2500 Crew Cab", "2500 Mega Cab", "2500 Regular Cab", "3500 Crew Cab", "3500 Mega Cab", "3500 Regular Cab", "C/V", "C/V Tradesman", "Dakota Crew Cab", "Dakota Extended Cab"]
};

/**
 * Chat API
 */
var chatApi = new function() {
// private data
	var scriptObj = document.createElement( 'script' );

// private methods
	var _prepareUrl	= function( siteId, planId ) {
		// default values
		var scriptUrl = "https://chatserver.comm100.com/js/LiveChat.js";
		var scriptParams = "?siteId=SITE_ID_HERE&amp;planId=PLAN_ID_HERE&amp;partnerId=-1";
		
		// customize it
		var customParams = scriptParams.replace( "SITE_ID_HERE", siteId );
		customParams = customParams.replace( "PLAN_ID_HERE", planId );
		return scriptUrl+customParams;
	};

// public data 
	// load script after page has loaded
	this.loadChatScript = function( siteId, planId ) {
		// set missing object data
		scriptObj.type = 'text/javascript';
		scriptObj.src = _prepareUrl( siteId, planId );
		$("footer").after( scriptObj );
	};
	
	// load chat thumbnail after page has loaded
	this.loadChatThumbnail = function() {
		// default link + image html string
		var defaultString = '<a href="http://www.comm100.com/livechat" target="_blank" onclick="comm100_47054.openChatWindow(event,5000001,-1);return false;" class="chat-link"><img style="border:0px" id="comm100_ButtonImage" src="https://chatserver.comm100.com/BBS.aspx?siteId=47054&amp;planId=5000001&amp;partnerId=-1"></img></a>';
		
		// append to html
		$("footer").after( defaultString );
	};
};

/**
 * Coupon form API
 */
var couponApi = new function() {
// private data
	var config = {
		"containerSelector":"#contactable"
	};
	var openCloseCount = 0;
	var fieldRequiredStep1 = {
		"condition":		"input[name=condition]",
		"name":				"#coupon_name",
		"telephone":		"#coupon_telephone",
		"email":			"#coupon_email",
		"shopping_status":	"#coupon_shopping_status",
		"make":				"#coupon_make",
		"model":			"#coupon_model"
	};
	var fieldRequiredStep2 = {
		"date":	"#coupon_date",
		"time":	"#coupon_time"
	};
	var defaultCouponUrl = "http://"+location.host+"/coupons?amt=";
	
// private methods
	// timed form slide trigger
	var triggerSlide = function( action, timeDelay ) {
		// overwrite defaults
		action		= action || "open";
		timeDelay	= timeDelay || 2800;
		
		// execute action
		if ( action == "open" ) {
			setTimeout( "$( \"#contactable_inner\" ).trigger( \"click\" )", timeDelay );	
		}
	}
	
	// set all events
	var setEventHandlers = function() {
		// keep track of open or close
		$( "#contactable_inner, #xf_close" ).click(
			function( e ) {
				// 0 = closed
				// 1 = opened
				if ( openCloseCount == 0 ) {
					openCloseCount = 1;	
				} else if ( openCloseCount == 1 ) {
					openCloseCount = 0;
					
					// reset form
					resetForm();
				}
			} );
		
		// change in status dropdown
		$( "#coupon_shopping_status" ).change(
			function( e ) {
				if ( this.value != "" ) {
					// go to step 1.b
					$( ".step-1.sub-step" ).removeClass( "is-hidden" );
					//$( ".can-hide" ).addClass( "is-hidden" );
				} else {
					// go back to step 1.a
					$( ".step-1.sub-step" ).addClass( "is-hidden" );
					//$( ".can-hide" ).removeClass( "is-hidden" );
				}
			} );
			
		// change in make dropdown
		$( "#coupon_make" ).change(
			function( e ) {
				// select dropdown
				var targetSelect = $( fieldRequiredStep1.model ).get( 0 );
				
				// empty dropdown
				targetSelect.options.length = 1;
				
				// determine if we need to disable model dropdown
				if ( this.value == "" ) {
					// add gray "disabled" effect
					$( targetSelect ).removeClass( "select2" ).addClass( "select2" ).attr( 'disabled', true );
				} else {
					// re-populate with new data
					if ( typeof models[this.value] !== "undefined" ) {
						// add new ones
						$.each( models[this.value], function( key, value ) {
							$( targetSelect ).append( $( "<option></option>" ).attr( "value", value ).text( value ) );
						} );
					}
					
					// remove gray "disabled" effect
					$( targetSelect ).removeClass( "select2" ).attr( 'disabled', false );
				}
				
				// remake forms
				jcf.customForms.updateElement( "coupon_model" );
			} );
			
		// change in date and time
		$( "#coupon_date", "#contactForm" ).change(
			function( e ) {
				var newUrl = defaultCouponUrl+"200&date="+$( this ).val();
				if ( $( "#coupon_time", "#contactForm" ).val() != "" ) {
					newUrl += "&time="+$( "#coupon_time", "#contactForm" ).val();	
				}
				$( ".submit .step-2 .yes" ).attr( "href", newUrl );
			} );
		$( "#coupon_time", "#contactForm" ).change(
			function( e ) {
				var newUrl = defaultCouponUrl+"200&time="+$( this ).val();
				if ( $( "#coupon_date", "#contactForm" ).val() != "" ) {
					newUrl += "&date="+$( "#coupon_date", "#contactForm" ).val();	
				}
				$( ".submit .step-2 .yes" ).attr( "href", newUrl );
			} );
		
		// click submit button (step 1)
		$( ".submit.step-1", "#contactForm" ).click(
			function( e ) {
				// prevent default
				e.preventDefault();
				
				// check required fields
				doesQualifyForStepTwo( true );
			} );
		
		// submit step-2
		$( ".submit.step-2", "#contactForm" ).click(
			function( e ) {
				// default flag
				var isValid = true,
					requireAppointment = $( this ).hasClass( "yes" ),
					buttonRef = this;
				
				// determine if we need the two last fields
				if ( requireAppointment ) {
					// check fields
					if ( $( fieldRequiredStep2.date ).val() == "" ) {
						isValid = false;	
					}
					if ( $( fieldRequiredStep2.time ).val() == "" ) {
						isValid = false;	
					}
					
					// notify users
					if ( isValid == false ) {
						alert( unescape( "Por%20favor%2C%20aseg%FArese%20de%20que%20la%20fecha%20y%20la%20hora%20esten%20seleccionada." ) );
						return false;
					}
					
					// update certificate amount
					$( "#coupon_certificate_value" ).val( 200 );
				} else {
					// ensure certificate is only for 100
					$( "#coupon_certificate_value" ).val( 100 );
				}
				
				// proceed with submission
				try {
					// hide all buttons
					$( ".submit.step-2" ).addClass( "is-hidden" );
					
					// show loader
					$( ".loader", "#contactForm" ).removeClass( "is-hidden" );
					$.post(
						"http://"+location.host+"/"+$( "#contactForm" ).attr( "action" ),
						$( "#contactForm" ).serialize(),
						function( jsonData ) {
							// determin what to do
							if ( jsonData.status == 2 ) {
								// success, download pdf
								$( "#coupon_submit_result" ).val( "1" );
								$( "#xf_close" ).trigger( "click" );
								
								// append extra parameters
								/*if ( $( "#coupon_certificate_value" ).val() == 200 ) {
									console.log( "in here" );
									var currHref = $( buttonRef ).attr( "href" );
									currHref += "&date="+$( fieldRequiredStep2.date ).val();
									currHref += "&time="+$( fieldRequiredStep2.time ).val();
									$( buttonRef ).attr( "href", currHref );
									console.log( $( buttonRef ).get( 0 ).href );
								} else {
									console.log( "out here" );
								}*/
								
								// notify user
								if ( "id" in jsonData && typeof noti_api != "undefined" && "reportNewLead" in noti_api ) {
									noti_api.reportNewLead( jsonData.id );
								}
							} else if( jsonData.status == 1 ) {
								// missing fields
								alert( unescape( jsonData.alert ) );
								$( "#coupon_submit_result" ).val( "0" );
								
								// show buttons again
								$( ".submit.step-2" ).removeClass( "is-hidden" );
								$( ".loader", "#contactForm" ).addClass( "is-hidden" );
							} else {
								// fatal error
								alert( unescape( jsonData.alert ) );
								$( "#coupon_submit_result" ).val( "0" );
								
								// close coupon window
								$( "#xf_close" ).trigger( "click" );
							}
						},
						"json" );
				} catch( err ) {
					alert( unescape( "Disculpe%2C%20ocurri%F3%20un%20error%20inesperado.%20Por%20favor%2C%20intentarlo%20de%20nuevo%20m%E1s%20tarde." ) );
				}
				
				// determine what to do
				if ( $( "#coupon_submit_result" ).val() == 0 || $( "#coupon_submit_result" ).val() == "0" ) {
					e.preventDefault();
				}
			} );
	};
	
	// open step two
	var doesQualifyForStepTwo = function( isSubmit ) {
		// default value
		var isSubmit = isSubmit || false;
		
		// determine if they are all valid
		var isValid = true;
		$.each( fieldRequiredStep1,
			function( index, elementId ) {
				if ( $( elementId ).val() == "" ) {
					// not valid
					isValid = false;
				}
			} );
			
		// determine if they qualify for next step
		if ( isValid ) {
			var emailValue = $( fieldRequiredStep1.email ).val();
			if ( emailValue.indexOf( "@" ) >= 0 && emailValue.indexOf( "." ) >= 0 ) {
				// proceed to 2nd step
				switchToStepTwo();
			} else {
				// email not valid (notify user)
				alert( unescape( "Por%20favor%2C%20introduzca%20un%20correo%20electr%F3nico%20v%E1lido." ) );
			}
		} else if( isSubmit ) {
			alert( unescape( "Hay%20casillas%20requeridas%20que%20a%FAn%20se%20encuentran%20vac%EDas." ) );
		}
	};
	
	// switch form to step two
	var switchToStepTwo = function() {
		// hide all of step one
		$( ".step-1" ).addClass( "is-hidden" );
		
		// show step 2
		$( ".step-2" ).removeClass( "is-hidden" );
	};
	
	// reset fields in form
	var resetForm = function() {
		// empty all fields
		$( "input.text", "#contactForm" ).val( "" );							// text fields
		$( "input[name=condition]", "#contactForm" ).attr( "checked", false );	// radio fields
		
		// remake dropdowns
		$( "#coupon_shopping_status" ).val( "" );
		jcf.customForms.updateElement( "coupon_shopping_status" );
		$( "#coupon_make" ).val( "" );
		jcf.customForms.updateElement( "coupon_make" );
		$( "#coupon_model" ).removeClass( "select2" ).addClass( "select2" ).attr( "disabled", true );
		$( "#coupon_model" ).get( 0 ).options.length = 1;
		jcf.customForms.updateElement( "coupon_model" );
		
		// hide loader
		$( ".loader", "#contactForm" ).addClass( "is-hidden" );
		
		// hide step two
		$( ".step-2" ).removeClass( "is-hidden" ).addClass( "is-hidden" );
		
		// show step one
		$( ".step-1" ).removeClass( "is-hidden" );
		
		// hide substeps
		$( ".sub-step" ).removeClass( "is-hidden" ).addClass( "is-hidden" );
	};
	
	// do final check (on step 2) before submitting
	var finalValidation = function( requireAppointment ) {
		
	};

// public methods
	// constructor
	this.init = function() {
		// init jquery plugin
		$( config.containerSelector ).contactable();
		
		// mask fields
		$( fieldRequiredStep1.telephone ).mask( "(999) 999-9999" );
		$( fieldRequiredStep2.date ).mask( "99/99/9999" );
		
		// init datepicker
		$( fieldRequiredStep2.date ).datepicker();
		$( fieldRequiredStep2.date ).datepicker( "option", "dateFormat", "dd/mm/yy" );
		
		// hide all substeps and non initial steps
		$( ".sub-step, .step-2" ).addClass( "is-hidden" );
		
		// set event handlers
		setEventHandlers();
		
		// trigger auto open
		triggerSlide();
	};
};

/**
 * Image 404 API
 */
var image404Api = new function() {
// private data
	var pageImages = null;
// private methods

// public methods
	this.init = function() {
		// prepare path to 404 image
		pathTo404Image = "http://"+location.host+"/"+themeImagePath+"img-no-pic-thumb.jpg";
		
		// get and save all images
		pageImages = $( "img" );
		
		$( "img" ).bind( "error",
			function( e ) {
				// change image source
				$( this ).attr( "src", pathTo404Image );
			} );
	};
};

/**
 * Scroll API
 */
var scrollApi = new function() {
// private data

// private methods

// public methods
	this.scrollToAnchor = function( anchorId ) {
		var elementToScrollTo = $( anchorId );
		jQuery( "body, html" ).stop().animate( { scrollTop:elementToScrollTo.offset().top }, 800 );
		
		//console.log( "top: "+elementToScrollTo.offset().top+"   outer: "+elementToScrollTo.outerHeight() )
	};
};

/**
 * Anchor API
 */
var anchorApi = new function() {
// private data
	var methodsAvailable = [];
		
// private encapsulated methods
	methodsAvailable["activateEnlargeIconHover"] = function( selector, nextSelectorCat ) {
		// make image's "enlarge" icon trigger hover state when image is hovered
		$( selector ).bind( "mouseover", function() {
			if ( nextSelectorCat == "next" ) {
				$( this ).next().addClass( "hovering" );
			} else if ( nextSelectorCat == "parentParentNextNext" ) {
				$( this ).parent().parent().next().next().addClass( "hovering" );
			} else if ( nextSelectorCat == "parentParentNextSecondChild" ) {
				$( this ).parent().parent().next().children( ".btn-more" ).addClass( "hovering" );
			} else if ( nextSelectorCat == "parentPreviousSecondChild" ) {
				$( this ).parent().prev().children( ".btn-more" ).addClass( "hovering" );
			}
		} ).
		bind( "mouseout", function() {
			if ( nextSelectorCat == "next" ) {
				$( this ).next().removeClass( "hovering" );	
			} else if ( nextSelectorCat == "parentParentNextNext" ) {
				$( this ).parent().parent().next().next().removeClass( "hovering" );
			} else if ( nextSelectorCat == "parentParentNextSecondChild" ) {
				$( this ).parent().parent().next().children( ".btn-more" ).removeClass( "hovering" );
			} else if ( nextSelectorCat == "parentPreviousSecondChild" ) {
				$( this ).parent().prev().children( ".btn-more" ).removeClass( "hovering" );
			}
		} );
	};
	
// public methods
	// apply function to selected anchors
	this.addToAnchors = function( selector, nextSelectorCat, actionToAdd ) {
		if (  typeof methodsAvailable[actionToAdd] !== "undefined" ) {
			methodsAvailable[actionToAdd]( selector, nextSelectorCat );
		}
	};
};

/**
  * Feedback/Extra form API
  */
var xformApi = new function() {
// private data
	var date = new Date();
	
// private methods
	var prepareEvents = function() {
		// onClick
		$( '#xf_close' ).click(
			function( e )
			{
				// array holding field id's
				var dropdowns = [ '#xf_model', '#xf_transmission' ];
				var fields = [ '#xf_color', '#xf_name', '#xf_telephone', '#xf_email', '#xf_message' ];
				
				// clear custom dropdowns
				$( "#xf_make" ).prev().removeClass( "invalid-field" ).children( ".center" ).text( "Marca: *" );
				$( "#xf_model" ).prev().removeClass( "invalid-field" ).children( ".center" ).text( "Modelo: *" );
				
				// empty list
				$( "#xf_model" ).get( 0 ).options.length = 1;
				jcf.customForms.updateElement( "xf_model" );
				
				// clear custom fields
				for( var j = 0; j < fields.length; j++ ) {
					$( fields[j] ).removeClass( "invalid-field" ).val( $( fields[j] ).get( 0 ).defaultValue );
				}
			} );
		
		// onClick
		$( '#xf_submit' ).click(
			function( e )
			{
				// validate
				if( validate() )
				{
					// clear disclaimer area
					$( '#xf_disclaimer' ).html( "" );
					
					// hide button and show loader
					$( '.find-my-car' ).removeClass( 'is-hidden' );
					$( this ).addClass( 'is-hidden' );
					
					// submit form
					$( '#elite-order-form' ).submit();
				}
				else
				{
					// send error message
					$( '#xf_disclaimer' ).html( '<span class="red"><strong>Hay casillas requeridas que a&uacute;n se encuentran vac&iacute;as.</strong></span>' );
				}
				
				// prevent default
				e.preventDefault();
				return false;
			} );
		
		// onSubmit
		$( '#elite-order-form' ).submit(
			function( e )
			{
				// parse data
				var name = $( '#xf_name' ).val().split( " " );
				
				// prepare data message
				var data = {};
				data.cid = $( '#xf_cid' ).val();
				data.subject = "Orden FIND MY CAR: Pedido de Vehiculo Nuevo";
				data.message = "Vehiculo: "+ $( '#xf_make' ).val() +" "+ $( '#xf_model' ).val() + " " + date.getFullYear() + "<br />" +
							   "Color: " + $( '#xf_color' ).val() + "<br />" +
							   "Detalles: " + $( '#xf_message' ).val();
				data.fname = name[0];
				data.lname = name[1];
				data.telephone = $( '#xf_telephone' ).val();
				data.email = $( '#xf_email' ).val();
				
				// send to server
				$.post( 'http://' + location.host + '/' + $( this ).attr( 'action' ),
					data,
					function( data )
					{
						// Parse returned data, and make json obj
						data = $.parseJSON( data );
						
						// Hide Loader
						$( '.find-my-car' ).addClass( 'is-hidden' );
						
						// Determine what to do
						if( data.status == 2 )
						{
							// Lock Form
							$( 'input, textarea, select', '#elite-order-form' ).attr( 'disabled', true );
							
							// Notify Users of new lead
							if( data.id )
							{
								// use noti_api
								noti_api.reportNewLead( data.id );
								
								// close sidebar
								$('#xf_close').trigger( 'click' );
							}
						}
						else if( data.status == 1 )
						{
							// allow resubmit
							$( '#xf_submit' ).removeClass( 'is-hidden' );
						}
						
						// Notify user
						alert( unescape( data.alert ) );
					} );
				
				// stop default behavior
				e.preventDefault();
				return false;
			} );
	};
	
	var validate = function() {
		// set flag
		var is_valid = true;
		var tempElem;
		
		// check conditions
		if( $( '#xf_make' ).get( 0 ).selectedIndex == 0 || $( '#xf_make option:selected' ).text() == "Marca: *" )
		{	is_valid = false; $( '#xf_make' ).prev().addClass( "invalid-field" ); }else{ $( '#xf_make' ).prev().removeClass( "invalid-field" ); }
		
		if( $( '#xf_model' ).get( 0 ).selectedIndex == 0 || $( '#xf_model option:selected' ).text() == "Modelo: *" )
		{	is_valid = false; $( '#xf_model' ).prev().addClass( "invalid-field" ); }else{ $( '#xf_model' ).prev().removeClass( "invalid-field" ); }
		
		if( $( '#xf_color' ).val() == '' || $( '#xf_color' ).val() == $( '#xf_color' ).get( 0 ).defaultValue )
		{	is_valid = false; $( '#xf_color' ).addClass( "invalid-field" ); }else{ $( '#xf_color' ).removeClass( "invalid-field" ); }
		
		if( $( '#xf_name' ).val() == '' || $( '#xf_name' ).val() == $( '#xf_name' ).get( 0 ).defaultValue )
		{	is_valid = false; $( '#xf_name' ).addClass( "invalid-field" ); }else{ $( '#xf_name' ).removeClass( "invalid-field" ); }
		
		if( $( '#xf_telephone' ).val() == '' || $( '#xf_telephone' ).val() == $( '#xf_telephone' ).get( 0 ).defaultValue )
		{	is_valid = false; $( '#xf_telephone' ).addClass( "invalid-field" ); }else{ $( '#xf_telephone' ).removeClass( "invalid-field" ); }
		
		if( $( '#xf_email' ).val() == '' || $( '#xf_email' ).val() == $( '#xf_email' ).get( 0 ).defaultValue )
		{	is_valid = false; $( '#xf_email' ).addClass( "invalid-field" ); }else{ $( '#xf_email' ).removeClass( "invalid-field" ); }
		
		if( $( '#xf_message' ).val() == '' || $( '#xf_message' ).val() == $( '#xf_message' ).get( 0 ).defaultValue )
		{	is_valid = false; $( '#xf_message' ).addClass( "invalid-field" ); }else{ $( '#xf_message' ).removeClass( "invalid-field" ); }
		
		// return verdict
		return is_valid;
	};

// public methods
	this.init = function() {
		// prepare all events
		prepareEvents();	
	}
	
};

/**
  * CMS API
  * -------
  * Contains all the methods that help include/execute JS in CMS pages throughout the sites
  */
var cms_API = new function() {
	
// public methods
	this.onJQReady = function( callbacks ) {
		$( document ).ready(
			function()
			{
				/* Execute all the call backs */
				$.each( callbacks, function( index, func_to_exec )
				{ 
					func_to_exec();
				} );
			} );
	};
};

/**
  * Begin callbacks for entire site
  */
var sitewide_callbacks = [];

// Fix all images callback
sitewide_callbacks[0] =
	function()
	{
		// init image 404 swap
		image404Api.init();
		
		// init coupon form
		couponApi.init();
		
		// init chat sitewide
		chatApi.loadChatScript( 47054, 5000001 );
		chatApi.loadChatThumbnail();
	};
	
// Kill JS-Links callback
sitewide_callbacks[1] =
	function()
	{
		$( '.js-link' ).click(
			function( e ) {
				// prevent defaul click
				e.preventDefault();
			} );
	};

// Submit all sitewide callbacks
cms_API.onJQReady( sitewide_callbacks );