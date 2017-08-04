function handle_dot_click( event )
{
	var name = event.target.getAttributeNS( null, "id" );
	var point_elm = document.getElementById(name + "_point");

	if(point_elm == null) {
		point_elm = document.getElementById(name);
		name = name.replace("_line", "");
	}	

	var mode = point_elm.getAttributeNS( null, "class" );

	if( mode == "on" || mode == "off" )
	{
		var new_mode;

		if( mode == "on" )
			new_mode = "off";
		else
			new_mode = "on";

		// Tell HTML to AJAX out the selection
		top.toggle_column( name, true );

		// Update the svg color
		point_elm.setAttributeNS( null, "class", new_mode );
	}
}

function handle_dot_over( event )
{
  toggle_hover( event, true );
}

function handle_dot_out( event )
{
  toggle_hover( event, false );
}

function toggle_hover( event, state )
{
  var name = event.target.getAttributeNS( null, "id" );
  var dot = document.getElementById(name);
  var x = parseFloat(dot.getAttributeNS( null, "cx" ));
  var y = parseFloat(dot.getAttributeNS( null, "cy" ));
  var radius = parseFloat(dot.getAttributeNS( null, "r" ));
  
  top.toggle_hover( name, x + radius, y - radius, state);
}
