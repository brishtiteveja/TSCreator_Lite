{javascript,begin}
<script src="{*value}" type="text/javascript"></script>
{javascript,end}

<div id="chartDiv">
	<input type="hidden" name="default_start_age" value="{default_start_age}" />
	<input type="hidden" name="default_end_age" value="{default_end_age}" />
	<input type="hidden" name="default_vertical_scale" value="{default_vertical_scale}" />
	<input type="hidden" name="current_start_age" value="{current_start_age}" />
	<input type="hidden" name="current_end_age" value="{current_end_age}" />
	<input type="hidden" name="current_vertical_scale" value="{current_vertical_scale}" />

	<p class='img'>
		
		{map_image_svg,begin}
	  <input type="checkbox" {configure_popup,begin}checked="checked"{configure_popup,end} name="configure_popup" /> Information Popups<br>
		
		<object id="map_image_svg" data="{*src}" width="{*width}" height="{*height}" type="image/svg+xml">
		</object>
		{map_image_svg,end}

		{map_image_png,begin}
		<img usemap="#image_map" src="{*src}" width="{*width}" height="{*height}" />
		{map_image_png,end}

		<map name="image_map">
		{img_map,begin}
			<area id="img_map_{*id}" title="{*note}" href="{*href}" coords="{*x},{*y},17" shape="circle" />
		{img_map,end}
		</map>
	</p>

			<p style="text-align: center;">
				<input type="submit" name="generate3" value="Generate Chart" />
			</p>

	<table id="map_table">
		<tr>
				<th>Enable/Disable</th>
				<th>Column Name</th>
				<th>Notes</th>
		</tr>

		{datacols,begin}
		<tr>
			<td class='dots center'><img id="{*id}" src="{*enable_image}" /></td>
			<td>{*name}</td>
			<td>{*notes}</td>
			<div class="popupHover" id="div_{*id}">
        <p><span>Name:</span> {*name}</p>
        <p><span>Min Age:</span> {*min} Ma</p>
        <p><span>Max Age:</span> {*max} Ma</p>
        <p><span>Note:</span> {*notes}</p>
      </div>
		</tr>
		{datacols,end}

	</table>
			<p style="text-align: center;">
				<input type="submit" name="generate2" value="Generate Chart" />
			</p>
	<br />
</div>
