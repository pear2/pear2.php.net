<h1>Package :: <?php echo $this->package->n; ?></h1>
<div class="three_col left">
<?php 
echo nl2br(htmlentities($this->package->d));
?>
</div>
<div class="two_col featurebox right">
<h2>Installation</h2>
<code>$>php pyrus.phar install <?php echo $this->package->n; ?></code>
</div>