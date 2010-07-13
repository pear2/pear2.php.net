<?php

if (   count($context->dependencies['required']->php) > 0
    || count($context->dependencies['required']->package) > 0
    || count($context->dependencies['required']->extension) > 0
    || count($context->dependencies['required']->os) > 0
) {

?>
    <div class="package-dependencies">
        <h3>Dependencies for <?php echo $context->name; ?></h3>
        <ul>

<?php

// php dependencies
foreach ($context->dependencies['required']->php as $php) {

    if ($php->min && $php->max) {
        $phpTitle = 'PHP ≥ ' . $php->min . ' ≤ '. $php->max;
    } else if ($php->min) {
        $phpTitle = 'PHP ≥ ' . $php->min;
    } else if ($php->max) {
        $phpTitle = 'PHP ≤ ' . $php->max;
    }

    echo '<li>' . $phpTitle. '</li>';
}


// package dependencies
foreach ($context->dependencies['required']->package as $name => $package) {
    echo '<li><a href="http://'.$name.'">' . $name . '</a></li>';
}

// extension dependencies
foreach ($context->dependencies['required']->extension as $name => $extension) {

    $extensionTitle = $name . ' extension';

    if ($extension->min && $extension->max) {
        $extensionTitle .= ' ≥ ' . $extension->min . ' ≤ '. $extension->max;
    } else if ($extension->min) {
        $extensionTitle .= ' ≥ ' . $extension->min;
    } else if ($extension->max) {
        $extensionTitle .= ' ≤ ' . $extension->max;
    }

    echo '<li>' . $extensionTitle . '</li>';
}

// os dependencies
foreach ($context->dependencies['required']->os as $name => $supported) {

    if ($supported) {
        $osTitle = 'only works on ' . $name;
    } else {
        $osTitle = 'does not works on ' . $name;
    }

    echo '<li>' . $osTitle . '</li>';
}

?>
        </ul>
    </div>

<?php
}
?>
