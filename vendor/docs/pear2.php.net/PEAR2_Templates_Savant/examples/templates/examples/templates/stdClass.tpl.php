<h2>This is stdClass.tpl.php</h2>
<p>This represents the default mapping of class name to template.</p>
<p>The class of this context is: <?php echo get_class($context); ?></p>
<p>The $context object contains the stdClass object with access to all the member
variables and functions, such as $context->var1</p>
<?php echo $context->var1; ?>