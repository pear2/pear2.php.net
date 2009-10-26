<h1>Package :: <?php echo $context->package->name; ?></h1>
<div class="three_col left">
<?php 
echo nl2br(htmlentities($context->package->description));
?>
</div>
<div class="two_col featurebox right">
<h2>Installation</h2>
<code>$>php pyrus.phar install <?php echo $context->package->name; ?></code>
</div>
<div class="col right">
    <h3>Releases</h3>
    <ul>
        <?php foreach ($context->releases as $version=>$release): ?>
        <li><?php echo $version; ?></li>
        <?php endforeach; ?>
    </ul>
</div>