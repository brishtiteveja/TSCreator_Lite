<?php
class Page {

	private $tags; 
	public $has_footer;
	public $has_header;

	private $replacement;

	public function __construct()
	{
		// Start with no input but with header and footer
		$this->tags = array();

		$this->has_header = true;
		$this->has_footer = true;
	}

	public function reset()
	{
		$this->tags = array();
	}

	public function assign( $tag, $val )
	{
		$this->tags[$tag] = $val;
	}

	public function output($template)
	{
		$webroot = dirname(Path::get()->getWebPath( "page_" . $template ));
		$webfiles = array();

		// Attached all the style sheets for this template
		foreach( glob( dirname(Path::get()->getFilePath( "page_" . $template )) . "/css/*.css" ) as $files )
			$webfiles[] = $webroot . "/css/" . basename($files) ;

		$this->assign( "stylesheets", $webfiles );	

		$webfiles = array();

		// Attached all the javascript for this template
		foreach( glob( dirname(Path::get()->getFilePath( "page_" . $template )) . "/js/*.js" ) as $files )
			$webfiles[] = $webroot . "/js/" . basename($files) ;

		$this->assign( "javascript", $webfiles );

		// Allow for embeded PHP in template files
		ob_start();

		if( $this->has_header )
			include( Path::get()->getFilePath("template_header") );

		include( Path::get()->getFilePath("template_" . $template) );	

		if( $this->has_footer )
			include( Path::get()->getFilePath("template_footer") );

		$output = ob_get_contents();
		
		ob_end_clean();

		// Replace all the tags
		foreach( $this->tags as $tag => $value )
		{
			if( !is_array( $value ) )
			{
				$output = preg_replace("/\{{$tag}\}/", $value, $output);
			} else {
				// This is for a looping replacement (something like a drop down)
				// Note an empty array will remove the HTML all together
				$this->replacement = $value;
				$output = preg_replace_callback( "/\{{$tag},begin\}(.*)\{{$tag},end\}/s",
																				array( $this, 'replacement_callback' ),
																				$output );
			}
		}

		echo $output;
	}

	// This handles replaceing each loop
	private function replacement_callback( $matches )
	{
		$output = '';

		if( is_array($this->replacement[0]) )
		{
				foreach( $this->replacement as $replace )
				{
					$tmp = $matches[1];

					foreach( $replace as $tag => $value )
					{
						$tmp = preg_replace("/\{\*{$tag}\}/", $value, $tmp );
					}

					$output .= $tmp;
				}

		} else {
			foreach( $this->replacement as $tag => $value )
			{
				$tmp = preg_replace("/\{\*key\}/", $tag, $matches[1]);
				$output .= preg_replace("/\{\*value\}/", $value, $tmp);
			}
		}

		return $output;
	}
} 
?>

