            <p>
                <?php
                $markdown = new \PEAR2\Text\Markdown_Extra();
                echo $markdown->transform($context->description);
                ?>
            </p>

            <div class="package-release-notes">
                <h3>Release Notes - <?php echo $context->version['release']; ?></h3>
                <p>
                <?php
                $markdown = new \PEAR2\Text\Markdown_Extra();
                echo $markdown->transform($context->notes);
                ?>
                </p>
            </div>
