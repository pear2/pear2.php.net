<h1>PEAR2 Packages</h1>
<ul>
<?php
foreach ($this->directory as $package) {
	if (substr($package->getFilename(),0,1)!== '.'
		&& $package->isDir()) {
		echo '<li><a href="./?view=package&amp;package='.$package.'">'.$package.'</a></li>';
	}
}

?>
</ul>