<?php
foreach ($context as $date=>$package) {
    echo '<li id="'.$context->options["id"].'"><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'-'.$package->version['release'].'">'.str_replace("PEAR2_", "", $package->name).'-'.$package->version['release'].'<span> — '.date('F j', strtotime($date)).'</span></a></li>';
}?>
