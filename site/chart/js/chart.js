$(document).ready(function() {

	var svg_elm = false;
  var elm;
  var ratio; //aspect ratio of chart
  var fullwidth; //original width of chart
	var hideTimeLine = true;
	
	elm = $("#SVGobject");
	if( $(elm).length )
	{
	  //Makes javascript check every half sec to see if SVG is loaded
	  var get_svg_id = setInterval(get_svg, 500);
	}
	else
	{
	  elm = $("#chartObject");
	  if( $(elm).length )
	  {
	    //Weird thing to make the onload work all the time
	    elm[0].hasloaded = false;
	    elm[0].onload = get_png;
	    if( elm[0].complete )
	      elm[0].onload();
	  }
	}

	if( $(elm).length )
	{
		$("a.zfit").css("display", "inline");;
		$("a.z100").css("display", "inline");
		$("a.zin").css("display", "inline");
		$("a.zout").css("display", "inline");
	}

	$("a.showline").click( function() {

		var svg = document.getElementById("SVGobject");
		if( svg != null )
		{
			var timeLine = svg.getSVGDocument().getElementById("timeline");
			var timeLabel = svg.getSVGDocument().getElementById("TimeLineLabel");

			hideTimeLine = !hideTimeLine;
			if (timeLine && timeLabel) {
				timeLine.setAttribute("style", hideTimeLine ?  "stroke-opacity : 0;" :"stroke: red;stroke-opacity:0.5;");
				timeLabel.setAttribute("style",hideTimeLine ? "fill-opacity : 0;" :"font-size: 10;fill: red; fill-opacity:0.7;");
			}
		}

		return false;
	});


	$("a.zfit").click( function() {
	  $(elm).width("100%");
    $(elm).height("100%");
    var fitwidth = $(elm).width();
		chart_resize(fitwidth);

		return false;
	});

	$("a.z100").click( function() {
		chart_resize(fullwidth);

		return false;
	});

	$("a.zin").click( function() {
		chart_scale(1.1);

		return false;
	});

	$("a.zout").click( function() {
		chart_scale(0.9);

		return false;
	});

//	$(window).bind( "beforeunload", function() {
//		close_popup();
//	});
	
	//Finds full and fit widths in px for png
	function get_png()
	{
    fullwidth = $(elm).width();
    ratio = $(elm).height() / fullwidth;
    $(elm).width("100%");
    $(elm).height("100%");
    var fitwidth = $(elm).width();
    $(elm).width(fitwidth);
    $(elm).height(fitwidth * ratio);
    $(elm).removeClass("noshow"); //Makes chart show on page
	}
	
	//Finds full and fit widths in px for svg
	function get_svg()
  {
    var svg = document.getElementById('SVGobject');
    if( svg.contentDocument != null )
    { 
      svg = svg.contentDocument.getElementsByTagName('svg');

		 // Get viewbox here and check for undefined to fix IE from failing...
		 var viewbox = $(svg).attr("viewBox");
     if( svg != null && viewbox !== undefined )
     {
       clearInterval(get_svg_id);
       svg_elm = svg;
       viewbox = viewbox.split(/ /);
       fullwidth = parseInt(viewbox[2]);
       ratio = parseInt(viewbox[3]) / fullwidth;
	     fitwidth = $(elm).width();
       chart_resize(fitwidth);
       $(elm).removeClass("noshow"); //Makes chart show on page
			 $("a.showline").css("display", "inline");;
       return;
     } 
    }
  }

  //Changes size by a scaling factor
  function chart_scale(scale)
  {
    if( $(elm).length )
    {
      var width = $(elm).width() * scale;
      chart_resize(width);
    }
  }

  //Makes the chart have a given width, and put all sizes in terms of px
  function chart_resize(width)
  {
    if( $(elm).length )
    {
      var height = width * ratio;
      $(elm).attr("height", height + "px");
      $(elm).attr("width", width + "px");
      $(elm).width(width);
      $(elm).height(height);
      if( $(svg_elm).length )
      {
        $(svg_elm).attr("height", height + "px");
        $(svg_elm).attr("width", width + "px");
      }
    }
  }
});

function showPopup( event, text ) {
	var title = "TSCLite Popup";
	var width, height;

	// updating the location of the images on the server while looking for images
	var re = /src="(\w*).jpg/g;
	while (text.match(re))
		text=text.replace(re,'src="\.\./datapack_images\/Global\/$1.jpg');

	re = /src="(\w*).png/g;
	while (text.match(re))
		text=text.replace(re,'src="\.\./datapack_images\/Global\/$1.jpg');

	if(text.match(/<img/gi) != null)
	{
		width = 500;
		height = 300;
	} else {
		width = 300;
		height = 150;
	}

	// Required for iPad... 
	var $dialog = $('<div></div>').html(text);
	$dialog.find('a').wrap("<span />");

	$dialog.find('a').unbind("click").click(newWindow);

	var x = event.clientX - $(window).scrollLeft() + $("#SVGobject").position().left + 20;
	var y = event.clientY - $(window).scrollTop() - $dialog.parent('.ui-dialog:first').outerHeight() + $("#SVGobject").position().top;

	$dialog.dialog({
		title: title,
		modal: false,
		width: width,
		height: height,
		position: [ x, y ],
		show: {effect: 'drop', direction: 'up'}
	});	
}

//var popup;
//function showPopup( event, text ) {
//  var x = event.screenX;
//  var y = event.screenY;
  
// 	close_popup();
	 
//	// Generate window title from the text of being displayed

//	// Titles are less then useful...
//	var title = "TSCLite Popup";
//	//if( text.length )
//	//{
//	//	title = text.match(/(^[\w\d\s\.\(\)]+).*/)[1].split(/ /);
//	//	
//	//	var extended = "";
//	//	if( title.length > 3 )
//	//		extended = "...";
//  //
//	//	title = title.slice(0,3).join( " " ) + extended;
//	//}
//
//	var popup;
//	if(text.match(/<img/gi) != null)
//	{
//  	popup = window.open('about:blank', '_blank', 'toolbar=0,status=0,location=0,scrollbars=1,menubar=0,directories=0,titlebar=0,width=650,height=350');
//	} else {
//  	popup = window.open('about:blank', '_blank', 'toolbar=0,status=0,location=0,scrollbars=1,menubar=0,directories=0,titlebar=0,width=300,height=150');
//	}

//  popup.moveTo(x, y);
//	popup.document.title = title; 
//	popup.document.write("<html>");
//	popup.document.write("<head><title>" + title + "</title></head>");
//  popup.document.write("<body><span id='text'>" + text + "<span></body>");
//	popup.document.write("</html>");
//  $(popup.document.getElementsByTagName('html')).css('background-color', '#ffffaa');
//  element = popup.document.getElementById('text');
//  $(element).find('a').unbind("click").click(newWindow);
//}

function newWindow( event )
{
  window.open($(this).attr('href'), '_blank').focus();
  
  return false;
}


//function close_popup()
//{
//	if( typeof(popup) !== 'undefined' && popup.closed == false )
//		popup.close();
//}
