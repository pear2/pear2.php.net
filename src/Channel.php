<?php
class Channel
{
	public $file;
	
	function __construct($filename)
	{
		$this->file = new SplFileInfo(realpath($filename));
	}
}
