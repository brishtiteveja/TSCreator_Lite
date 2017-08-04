$(document).ready(function() {
	look_for_chart();
});

function look_for_chart()
{
	$.ajax({
	  cache : false,
		method : "GET",
		url : "ajax_action.php",
		data : ( { filename : $("input[name=filename]").val() } ),
		success: function (val) {
			if( val == "done" )
				window.location.replace(  "../chart/chart.php?filename=" + $("input[name=filename]").attr("value") );
			else
				setTimeout( "look_for_chart()", 1000 );
		}
	});

}
