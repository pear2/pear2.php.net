<h2>Player :: <?php echo $context->name; ?></h2>
<p>Years on team:</p>
<ul>
    <?php echo $savant->render($context->years_on_team, 'ListItem.tpl.php'); ?>
</ul>