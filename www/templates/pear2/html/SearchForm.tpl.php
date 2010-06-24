<?php

$keywords = (isset($parent->context->query)) ? $parent->context->query : null;

?>
<form method="get" action="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>search" id="find-packages">
    <div>
        <input type="search" placeholder="Package name or description …" size="30" name="q" value="<?php echo $keywords; ?>" /><input class="button" value="Search" type="submit" />
    </div>
</form>
