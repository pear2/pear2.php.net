<h1>PEAR2 Packages</h1>
<ul>
<?php
foreach ($this->packages as $package) {
	echo '<li><a href="./?view=package&amp;package='.$package.'">'.$package.'</a></li>';
}

?>
</ul>