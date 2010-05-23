 <div id="packages" class="pearbox">
            <div class="pearbox-header">
                <h2>Packages</h2>
                <form method="get" action="." id="find-packages">
                    <div>
                        <input type="search" placeholder="Package name or description …" size="30" name="q" /><input class="button" value="Search" type="submit" />
                        <input type="hidden" name="view" value="search" />
                    </div>
                </form>
            </div>
            <div class="pearbox-content">
                <ul class="categories">
                    <?php
                    foreach ($context as $category) : ?>
                    <li id="category-<?php echo $num; ?>" class="category">
                        <h3><a href=""><span class="category-title"><?php echo $category->name; ?></span> <span class="category-count"> (<?php echo count($category); ?>)</span></a></h3>
                        <div><?php
                        if (count($category)) {
                            echo '<ul>';
                            foreach ($category as $package) {
                                echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?></div>
                    </li>
                    <?php
                    endforeach; ?>
                     <li id="category-6" class="category">
  <h3>
   <a href="/packages.php?catpid=6&amp;catname=Encryption"><span class="category-title">Encryption</span> <span class="category-count">13</span></a>
  </h3>
  <div>
   <a href="/package/Crypt_Blowfish" class="category-package" title="Allows for quick two-way blowfish encryption without requiring the MCrypt PHP extension.">Crypt_Blowfish</a>,
   <a href="/package/Crypt_CBC" class="category-package" title="A class to emulate Perl's Crypt::CBC module.">Crypt_CBC</a>,
   <a href="/package/Crypt_CHAP" class="category-package" title="Generating CHAP packets.">Crypt_CHAP</a>,
   <a href="/package/Crypt_DiffieHellman" class="category-package" title="Implementation of Diffie-Hellman Key Exchange cryptographic protocol for PHP5">Crypt_DiffieHellman</a>,
   …
  </div>

 </li>
                    
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>