$(document).ready( function() {

	$("input[name=generate2]").click(function() {
		$("input[name=generate]").click();
	});

	$("input[name=generate3]").click(function() {
		$("input[name=generate]").click();
	});

	$("#map_table .dots img").click( function() {

		// General Strategy
		// Click on the same dot in the map
		// Let it change the tables dots like it already does
		var svg = document.getElementById("map_image_svg");

		if( svg != null )
		{
			var elm = svg.getSVGDocument().getElementById( $(this).attr("id") );

			if(elm == null) {
				elm = svg.getSVGDocument().getElementById( $(this).attr("id") + "_line");
			}

			$(elm).click();
		} else {
			$("#img_map_" + $(this).attr("id") ).click();
		}
	});

	$("map[name=image_map] area").click( function() {
		// toggle the column and block for session update before image reloading
		toggle_column( $(this).attr("id").replace(/img_map_(.*)/, "$1" ), false );	

		// cause the image to reload
		var now = new Date();
		var img = $(".img img");
		var src = $(img).attr( "src" );

		if( src.search(/reload_date/) > 0 )
		{
			src = src.replace( /(.*reload_date=).*/, "$1" + now.getTime() );
		} else {
			src = src + "&reload_date=" + now.getTime();
		}

		$(img).attr("src", src);

		return false;

	});
	
});

function toggle_column( name, async )
{
	var dot = $("#" + name);
	
	var href = $(dot).attr("src");
	
	if( href.match(/enable=disabled/ ) )
	{
		mode = "disabled";
	} else {
		if( href.match(/enable=on/) )
			var mode = "off";
		else
			var mode = "on";
	}

	href = href.replace(/(.*enable=)\w+/, "$1" + mode );

	$(dot).attr( "src", href);
	$.ajax({
		method : "GET",
		url : "../configure/ajax_actions.php",
		data : ( { action : "column",
							 datapack : $("li[id=selected] a").text(),
							 column : name,
							 state : mode } ),
		async : async
	});
}

function toggle_hover( name, x, y, state )
{
  if(!$("input[name=configure_popup]:checked").length)
    return;
  
  var div = $("#div_"+name);
  var svg = $("#map_image_svg");
  
  x += $(svg).position().left;
  y += $(svg).position().top;
  if(state)
  {
    $(div).css("left", x+"px");
    $(div).find('a').unbind("click").click(newWindow);
    y -= $(div).height();
    $(div).css("top", y+"px");
    $(div).css('z-index', 100);
    $(div).hover(hoverIn, hoverOut);
    $(div).stop(true, false).fadeTo("fast", 100);
  }
  else
  {
    $(div).css('z-index', 1);
    $(div).stop(true, false).fadeTo("fast", 0, function(){
      $(div).css({ top : 'auto', left : 'auto' });
      $(div).unbind("mouseenter mouseleave");
    });
  }
}

function hoverIn( event )
{
  var div = $(event.currentTarget);
  
  $(div).css('z-index', 100);
  $(div).stop(true, false);
  $(div).fadeTo("fast", 100);
}

function hoverOut( event )
{
  var div = $(event.currentTarget)
  
  $(div).stop(true, false);
  $(div).css('z-index', 1);
  $(div).fadeTo("fast", 0, function(){
      $(div).css({ top : 'auto', left : 'auto' });
      $(div).unbind("mouseenter mouseleave");
  });
  
}

function newWindow( event )
{
  window.open($(this).attr('href'), '_blank').focus();
  
  return false;
}

