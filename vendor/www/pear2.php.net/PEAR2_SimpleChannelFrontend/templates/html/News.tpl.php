<?php
// Set the title for the main template
$parent->context->page_title = 'News | ' . $frontend->getChannel()->name;
?>
<div id="news">
    <div class="grid_8 left">
    <h2>Latest News</h2>
    <p>Welcome to the next generation of PEAR channels.</p>
      <ol class="instructions">
            <li>Download the new PEAR installer:<br />
                <code><a href="http://pear2.php.net/pyrus.phar">pyrus.phar</a></code></li>
            <li>Discover this channel:<br />
                <code>$&gt;php pyrus.phar channel-discover <?php echo $frontend->getChannel()->name; ?></code></li>
            <li>Install packages:<br />
                <code>$&gt;php pyrus.phar install <?php echo $frontend->getChannel()->alias; ?>/<var>package</var></code><br />
                where package is the name of the package to install.</li>
        </ol>
    <p>Users can get started by reading
    <a href="http://pear.php.net/manual/en/installationpyrus.introduction.php">the introduction</a>.</p>
    </div>
    <div class="grid_4 right">
        <h3>Download</h3>
        <h4><a href="http://pear2.php.net/pyrus.phar">Download pyrus.phar</a></h4>
        <p>
          This website provides packages to install using the pyrus package installer.
          With pyrus you can install all the packages available on this channel, as well as any PEAR
          compatible package from a large number of repositories.</p>
    </div>
</div>
