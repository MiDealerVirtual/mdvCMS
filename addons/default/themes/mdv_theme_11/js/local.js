// Local Javascript

/**
  * Feedback/Extra form API
  * -------
  * Contains all the methods that help capture data from extra forms
  */
xform_API = {
	
	_date: new Date(),
	
	_prepareEvents: function()
	{
		// onClick
		$( '#xf_submit' ).click(
			function( e )
			{
				// validate
				if( xform_API._validate() )
				{
					// clear disclaimer area
					$( '#xf_disclaimer' ).html( "" );
					
					// hide button and show loader
					$( '#xf_loader' ).removeClass( 'jq_hide' );
					$( this ).addClass( 'jq_hide' );
					
					// submit form
					$( '#contactForm' ).submit();
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
		$( '#contactForm' ).submit(
			function( e )
			{
				// parse data
				var name = $( '#xf_name' ).val().split( " " );
				
				// prepare data message
				var data = {};
				data.cid = $( '#xf_cid' ).val();
				data.subject = "<h2>Orden ELITE: Pedido de Hyundai Nuevo</h2>";
				data.message = "<h4>Detalles de Orden Elite</h4>" +
							   "<strong>Vehiculo:</strong> Hyundai " + $( '#xf_model' ).val() + " " + xform_API._date.getFullYear() + "<br />" +
							   "<strong>Color:</strong> " + $( '#xf_color' ).val() + "<br />" +
							   "<strong>Transmision:</strong> " + $( '#xf_transmission' ).val() + "<br />" +
							   "<hr />" +
							   "<strong>Otros detalles:</strong> " + $( '#xf_message' ).val() + "<br />";
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
						$( '#xf_loader' ).addClass( 'jq_hide' );
						
						// Determine what to do
						if( data.status == 2 )
						{
							// Lock Form
							$( 'input, textarea, select', '#contactForm' ).attr( 'disabled', true );
							
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
							$( '#xf_submit' ).removeClass( 'jq_hide' );
						}
						
						// Notify user
						alert( unescape( data.alert ) );
					} );
				
				// stop default behavior
				e.preventDefault();
				return false;
			} );
	},
	
	_validate: function()
	{
		// set flag
		var is_valid = true;
		
		// check conditions
		if( $( '#xf_model' ).get( 0 ).selectedIndex == 0 )
			is_valid = false;
		if( $( '#xf_transmission' ).get( 0 ).selectedIndex == 0 )
			is_valid = false;
		if( $( '#xf_color' ).val() == '' )
			is_valid = false;
		if( $( '#xf_name' ).val() == '' )
			is_valid = false;
		if( $( '#xf_telephone' ).val() == '' )
			is_valid = false;
		if( $( '#xf_email' ).val() == '' )
			is_valid = false;
		if( $( '#xf_message' ).val() == '' )
			is_valid = false;
		
		// return verdict
		return is_valid;
	},
	
	init: function()
	{
		// prepare all events
		xform_API._prepareEvents();	
	}
	
};

/**
  * jQuery is ready
  */
$( document ).ready(
	function()
	{
		// Setup the elite window
		$( '#contactable' ).contactable();
		
		// initialize xform (with 2 second delay)
		setTimeout( "xform_API.init()", 2000 );
	} );