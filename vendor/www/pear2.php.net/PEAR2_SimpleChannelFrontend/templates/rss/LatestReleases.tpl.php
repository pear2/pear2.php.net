<?php
$item_table_of_contents = '<items><rdf:Seq>';
foreach($context as $package): ?>
<?php $item_table_of_contents .= '<rdf:li rdf:resource="' . $frontend->getURL() . $package->name . '-' . $package->version['release'] . '" />' . PHP_EOL; ?>
<item rdf:about="<?php echo $frontend->getURL() . $package->name . '-' . $package->version['release']; ?>">
 <title><?php echo $package->name . ' ' . $package->version['release']; ?></title>
 <link><?php echo $frontend->getURL() . $package->name . '-' . $package->version['release']; ?></link>
 <content:encoded>
 <?php echo htmlspecialchars(nl2br($package->notes)); ?>
 </content:encoded>
 <dc:date><?php echo date('c', strtotime($package->date.' '.$package->time)); ?></dc:date>
</item>
<?php endforeach;
$item_table_of_contents .= '</rdf:Seq></items>';
$savant->addFilters(function($buffer) use ($item_table_of_contents) {
    return str_replace('<!-- {items} -->', $item_table_of_contents, $buffer);
});
?>
