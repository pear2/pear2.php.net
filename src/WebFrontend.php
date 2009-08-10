<?php
class WebFrontend
{
	/**
	 * The channel object
	 * @var Channel
	 */
	static public $channel;
	
	public $page_content;
	
	protected $options = array('view' => 'news');
	
	protected $view_map = array('news'     => 'showNews',
								'packages' => 'listPackages',
								'package'  => 'showPackage');
	
	function __construct(Channel $channel, $options = array())
	{
		self::$channel = $channel;
		$this->options = array_merge($this->options, $options);
		$this->run();
	}
	
	function run()
	{
		if (!array_key_exists($this->options['view'], $this->view_map)) {
			throw new Exception('No view, or incorrect view specified.');
		}
		$this->page_content = $this->{$this->view_map[$this->options['view']]}();
	}
	
	function showNews()
	{
		include_once 'WebFrontend/News.php';
		return new WebFrontend_News();
	}
	
	function listPackages()
	{
		include_once 'WebFrontend/PackageList.php';
		return new WebFrontend_PackageList(self::$channel);
	}
	
	function showPackage()
	{
		include_once 'WebFrontend/Package.php';
		if (!preg_match('/[\w\_]+/', $this->options['package'])) {
			throw new Exception('Invalid package name.');
		}
		return new WebFrontend_Package(self::$channel, $this->options['package']);
	}
}
