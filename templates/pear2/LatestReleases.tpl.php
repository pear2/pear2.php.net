<div id="recent">
    <h2>Recent Packages</h2>
    <ul>
        <?php
        foreach ($context as $date=>$package) {
            echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'-'.$package->version['release'].'">'.$package->name.'-'.$package->version['release'].'<span> — '.date('F j', strtotime($date)).'</span></a></li>';
        }?>
    </ul>
</div>