$(document).ready(function() {

	var typingTimer;
	var typingInterval = 500;
	var load_defaults = "false";
	var map_image_type = "png";

	if( $("input[name=load_defaults]").attr("value") == "true" )
		load_defaults = "true";

	var curr_format = $('input[name=curr_format]').attr('value');
	$('option[value='+curr_format+']').attr('selected', 'selected');
	
	// Check for SVG support
	if( document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1") )
	{
		map_image_type = "svg";
	} else {
		// Were going to start in clasic mode, reflect that
		$("a.switch_img_png").css( "display", "none" );
		$("a.switch_img_svg").css("display", "inline");

		$("fieldset select option[value=svg]").remove();
		document.getElementById("chart_popup").disabled = true;
	}

	$("#mappack_select ul li a").click( function() {

		// Update tab
		$("#mappack_select #selected").attr("id", "");
		$(this).parent("li").attr("id", "selected");
		
		var mappack = $("#chartDiv");
		var go_to_pack = $(this).text();
		var popup_checked = $("input[name=configure_popup]");
		var event_col_bg = $("input[name=event_col_bg]");

    if( !popup_checked.length )
      popup_checked = 0;
    else
      popup_checked = $(popup_checked).filter(":checked").length;

		if( !event_col_bg.length )
			event_col_bg = 0;
		else
			event_col_bg = $(event_col_bg).filter(":checked").length;

		// Load in the new map
		$(mappack).fadeOut( "fast", function() {
			$.ajax({
				method : "GET",
				url : "../configure/configure.php",
				data : ( { datapack : go_to_pack,
				           popup_checked : popup_checked,
									 event_col_bg : event_col_bg,
									 load_defaults : load_defaults,
									 map_image_type : map_image_type } ),
				success: function (html) {


					// Check to see if we should set default times
					var input_start_age = $("#mainContent input[id='start_age']");
					var input_end_age = $("#mainContent input[id='end_age']");
					var input_vertical_scale = $("#mainContent input[id='vertical_scale']");

					if( !$(input_start_age).val().length && !$(input_end_age).val().length && !$(input_vertical_scale).val().length )
					{
						if( load_defaults == "true" )
						{
							$(input_start_age).val( $(html).find("input[name='default_start_age']").val() );
							$(input_end_age).val( $(html).find("input[name='default_end_age']").val() );
							$(input_vertical_scale).val( $(html).find("input[name='default_vertical_scale']").val() );
						} else {
							$(input_start_age).val( $(html).find("input[name='current_start_age']").val() );
							$(input_end_age).val( $(html).find("input[name='current_end_age']").val() );
							$(input_vertical_scale).val( $(html).find("input[name='current_vertical_scale']").val() );
						}
					}
					load_defaults = "false";

					$(mappack).replaceWith( html );
					$(mappack).fadeIn( "fast", function() { });
				}
			});
		});

		// Don't try to follow the link
		return false;
	});

	// Update the session with new start,end,vertical scale, and format data. Reload the map to reflect
	$("fieldset input:[id=start_age],[id=end_age],[id=vertical_scale]").blur( function() {
		clearTimeout(typingTimer);
		update_config_options();
	});

	$("fieldset input:[id=start_age],[id=end_age],[id=vertical_scale]").keyup(function() {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(update_config_options, typingInterval);
	});

	$("fieldset select").change( function () {
		update_config_options();
	});

	$("form").submit( function () {
		success = update_config_options();

		return success;
	});

	function update_config_options()
	{
		var success = false;
		var format = $("select option:selected").attr("value");
		
		// Disables popup checkbox if format isnt SVG
		if(format == "svg")
		  document.getElementById("chart_popup").disabled = false;
		else
		  document.getElementById("chart_popup").disabled = true;

		$.ajax({
			method : "GET",
			url : "../index/ajax_actions.php",
			async: false,
			data : ( { action : "age",
								 start_age : $("input[id=start_age]").attr("value"),
								 end_age : $("input[id=end_age]").attr("value"),
								 vertical_scale : $("input[id=vertical_scale]").attr("value"),
								 format : $("select option:selected").attr("value") } ),
			success: function ( msg ) {

				// Hide old error messages
				$( "p.error" ).css( "display", "none" ); 

				if( msg == "success" )
				{
					$("ul #selected a").click();
					$("input[name='generate']").removeAttr("disabled", "");
					$("input[name='generate2']").removeAttr("disabled", "");
					$("input[name='generate3']").removeAttr("disabled", "");
					success = true;
				} else {
					$("p[id=" + msg + "]").css("display", "block");
					$("input[name='generate']").attr("disabled", "disabled");
					$("input[name='generate2']").attr("disabled", "disabled");
					$("input[name='generate3']").attr("disabled", "disabled");
					success = false;
				}
			}
		});

		return success;
	}

	// Control dymanic and classic view switch
	$("a.switch_img_png").click( function() {
		$(this).css( "display", "none" );
		$("a.switch_img_svg").css("display", "inline");
		
		map_image_type = "png";

		$("#mappack_select li[id=selected] a").click();

		return false;
	});

	// Control dymanic and classic view switch
	$("a.switch_img_svg").click( function() {
		$(this).css( "display", "none" );
		$("a.switch_img_png").css("display", "inline");
		
		map_image_type = "svg";

		$("#mappack_select li[id=selected] a").click();

		return false;
	});

	// Reset to the tabs default
	$("a.load_defaults").click( function () {
		load_defaults = "true";

		$("fieldset input:[id=start_age],[id=end_age],[id=vertical_scale]").attr( "value", "" );

		$("#mappack_select li[id=selected] a").click();
		
		return false;
	});
	
	// Clear all selected dots
	$("a.clear_all").click( function () {
		$.ajax({
			method : "GET",
			url : "../index/ajax_actions.php",
			data : ( { action : "clear_all",
								 column : $("ul #selected").text() } ),
			success: function ( msg ) {
				$("#mappack_select li[id=selected] a").click();
			}
		});

		return false;
	});

	// Pick the default tab
	$("#mappack_select .default").click();

});
