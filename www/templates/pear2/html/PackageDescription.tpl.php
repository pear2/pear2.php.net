            <?php
            $markdown = new \PEAR2\Text\Markdown_Extra();
            echo $markdown->transform($context->getRaw('description'));
            ?>

            <div class="package-release-notes">
                <h3>Release Notes - <?php echo $context->version['release']; ?></h3>
                <?php
                $markdown = new \PEAR2\Text\Markdown_Extra();
                echo $markdown->transform($context->getRaw('notes'));
                ?>
            </div>
