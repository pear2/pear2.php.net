<html>
<head>
    <title><?php echo $context->name; ?></title>
</head>
<body>
    <h1><?php echo $context->name; ?></h1>
    <?php echo $savant->render($context->output); ?>
</body>
</html>