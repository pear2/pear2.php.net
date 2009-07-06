<?php 
class WebFrontend_PackageList extends DirectoryIterator
{
	public $directory;
	
	function __construct($dir)
	{
		parent::__construct($dir);
		$this->directory = $this;
	}
}
?>