<?
class Log {

	function __construct()
	{

	}

	public static function doLog( $message, $die = false )
	{
		echo $message;

		if( $die )
			die();
	}

	//logs msg to a file
	function logToFile($filename, $msg)
	{
		// open file
		$fd = fopen($filename, "a");
		// append date/time to message
		$str = "[" . date("Y/m/d h:i:s", mktime()) . "] " . $msg;

		//write string
		fwrite($fd, $str ."\n");
		//close file
		fclose($fd);
	}
	//sends log msg to an address
	function logToMail($msg, $address)
	{

		//append date/time to message
		$str = "[" . date("Y/m/d h:i:s", mktime()) ."] " . $msg;
		mail($address, "Log message", $str);

	}
}
?>
