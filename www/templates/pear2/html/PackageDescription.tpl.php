            <p>
                <?php
                $description = preg_replace("|\&lt\;\?php(.*)\?\&gt\;|Use", "highlight_string('<?php'.html_entity_decode('\\1').'?>', true)", $context->description);
                echo nl2br(trim($description));
                ?>
            </p>

            <div class="package-release-notes">
                <h3>Release Notes - <?php echo $context->version['release']; ?></h3>
                <p>
                    <?php echo nl2br(trim($context->notes)); ?>
                </p>
            </div>
