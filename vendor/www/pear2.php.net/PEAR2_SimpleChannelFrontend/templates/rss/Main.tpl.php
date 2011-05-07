<?php echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL; ?>
<rdf:RDF
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns="http://purl.org/rss/1.0/"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
>
    <channel rdf:about="<?php echo $frontend->getURL(); ?>">
        <link><?php echo $frontend->getURL(); ?></link>
        <dc:creator>pear-webmaster@lists.php.net</dc:creator>
        <dc:publisher>pear-webmaster@lists.php.net</dc:publisher>
        <dc:language>en-us</dc:language>
        <title><?php echo $frontend->getChannel()->summary; ?>: Latest releases</title>
        <description>The latest releases for <?php echo $frontend->getChannel()->summary; ?>.</description>
        <!-- {items} -->
    </channel>
    <?php echo $savant->render($context->page_content); ?>
</rdf:RDF>
