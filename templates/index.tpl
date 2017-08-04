<div id="mainContent">
	<br />

	<form method="get" action="<?php echo Path::get()->getWebPath('page_generate'); ?>">
		<fieldset>
			<legend>Chart Configuration Options</legend>


			<input type='hidden' name='load_defaults' value='{load_defaults}' />
			<input type='hidden' name='curr_format' value='{curr_format}' />
			
			<p>
				<label for="start_age">Top Age (Ma):</label>
				<input type="text" name="start_age" id="start_age" size="5" value="{start_age}" />

				<label for="end_age">Base Age (Ma):</label>
				<input type="text" name="end_age" id="end_age" size="5" value="{end_age}" />
			</p>

			<p>
				<label for="vertical_scale">Vertical Scale (cm/Ma):</label>
				<input type="text" name="vertical_scale" id="vertical_scale" size="5" value="{vertical_scale}" />

				<label for="format">Output Format:</label>
				<select name="format" id="format">
				{format,begin}
					<option value="{*key}">{*value}</option>
				{format,end}
				</select>
			</p>

			<p id="err_missing_age" class="error">Please enter a Start and End Age.</p>
			<p id="err_bad_start_age" class="error">The Start Age must be only numeric.</p>
			<p id="err_bad_stop_age" class="error">The End Age must be only numeric.</p>
			<p id="err_end_before_start_age" class="error">The End Age must be greater then the Start Age</p>
			<p id="err_missing_vertical_scale" class="error">Please enter a Vertical Scale</p>
			<p id="err_bad_vertical_scale" class="error">The Vertical Scale must be only numeric.</p>
			<p id="err_bad_format" class="error">Please select a Format.</p>

			<p>
			  <input type="checkbox" {chart_popup,begin}checked="checked"{chart_popup,end} name="chart_popup" id="chart_popup" /> Enable Popups On Generated Chart
				<br />
			  <input type="checkbox" {event_col_bg,begin}checked="checked"{event_col_bg,end} name="event_col_bg" id="event_col_bg" /> Enable Event Column Stage Background Colors 
			</p>
			<p>
				<input type="submit" name="generate" value="Generate Chart" />
			</p>

			<p class="small_controls">
					<span class="left">
					<a href="#" class="load_defaults">Load Defaults</a> | 
					<a href="#" class="clear_all">Clear All Selected</a>
					</span>

					<span class="right">
						<a href="#" class="switch_img_png">Switch to Classic View</a>
						<a href="#" class="switch_img_svg">Switch to Dynamic View</a>
					</span>
			</p>
		</fieldset>
	</form>
	
	<div id="allmappack">

	  <div id="mappack_select">

		  <ul>
			  {datapacks,begin}
				  <li><a class="{*default}" href="#">{*name}</a></li>
			  {datapacks,end}
		  </ul>
	  </div>

	  <div id="mappack">
		  <div id="chartDiv">
			  <!-- To be replaced by AJAXed in /configure/configure.php -->
			  <!-- <h3>Please choose a tab above to select a starting datapack</h3>	-->	
		  </div>
	  </div>
	</div>

</div>
