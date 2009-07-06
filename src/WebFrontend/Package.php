<?php 
class WebFrontend_Package
{
	public $package;
	
	function __construct($filename)
	{
		if (!file_exists($filename)) {
			throw new Exception('Invalid package.');
		}
		$this->package = simplexml_load_file($filename);
	}
}
?>