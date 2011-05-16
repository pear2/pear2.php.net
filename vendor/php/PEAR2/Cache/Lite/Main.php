<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Fast, light and safe cache system
 *
 * Cache_Lite is a fast, light and safe cache system. It's optimized
 * for file containers. Cache_Lite uses file locking and/or anti-corruption
 * tests to ensure data integrity.
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation; either version 2.1 of the
 * License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @category  Caching
 * @package   Cache_Lite
 * @author    Michael Gauthier <mike@silverorange.com>
 * @author    Fabien MARTY <fab@php.net>
 * @copyright 2002-2011 Fabien MARTY, 2011 Michael Gauthier
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear2.php.net/PEAR2_Cache_Lite
 */

namespace PEAR2\Cache\Lite;

/**
 * Main cache class
 *
 * @category  Caching
 * @package   Cache_Lite
 * @author    Michael Gauthier <mike@silverorange.com>
 * @author    Fabien MARTY <fab@php.net>
 * @copyright 2002-2011 Fabien MARTY, 2011 Michael Gauthier
 * @license   http://www.gnu.org/copyleft/lesser.html LGPL License 2.1
 * @link      http://pear2.php.net/PEAR2_Cache_Lite
 */
class Main
{
    // {{{ protected properties

    /**
     * Directory in which cache files are stored
     *
     * @var string
     * @see \PEAR2\Cache\Lite\Main::setCacheDir()
     */
    protected $cacheDir = '';

    /**
     * Cache life-time in seconds
     *
     * @var integer
     * @see \PEAR2\Cache\Lite\Main::setLifeTime()
     */
    protected $lifeTime = 3600;

    /**
     * Whether or not file locking is enabled
     *
     * @var boolean
     * @see \PEAR2\Cache\Lite\Main::setFileLocking()
     */
    protected $fileLocking = true;

    /**
     * Whether or not write control is enabled
     *
     * @var boolean
     * @see \PEAR2\Cache\Lite\Main::setWriteControl()
     */
    protected $writeControl = true;

    /**
     * Whether or not read control is enabled
     *
     * @var boolean
     * @see \PEAR2\Cache\Lite\Main::setReadControl()
     */
    protected $readControl = true;

    /**
     * Read control hash type
     *
     * @var string
     * @see \PEAR2\Cache\Lite\Main::setReadControlType()
     */
    protected $readControlType = 'crc32';

    /**
     * Whether or not file name protection is enabled
     *
     * @var boolean
     * @see \PEAR2\Cache\Lite\Main::setFileNameProtection()
     */
    protected $fileNameProtection = true;

    /**
     * Level of automatic cleaning to use
     *
     * @var integer
     * @see \PEAR2\Cache\Lite\Main::setAutomaticCleaningFactor()
     */
    protected $automaticCleaningFactor = 0;

    /**
     * Nested directory level
     *
     * @var integer
     * @see \PEAR2\Cache\Lite\Main::setNestedDirectoryLevel()
     */
    protected $nestedDirectoryLevel = 0;

    /**
     * Umask to use for nested directories
     *
     * If nested directories are enabled, this controls the umask set for
     * new directories.
     *
     * @var integer
     * @see \PEAR2\Cache\Lite\Main::setNestedDirectoryUmask()
     */
    protected $nestedDirectoryUmask = 0700;

    /**
     * Cache of cache file paths indexed by id-group
     *
     * @var array
     * @see \PEAR2\Cache\Lite\Main::getFilePath()
     */
    protected $filePaths = array();

    /**
     * Cache of cache file names indexed by id-group
     *
     * @var array
     * @see \PEAR2\Cache\Lite\Main::getFileName()
     */
    protected $fileNames = array();

    // }}}

    public function __construct()
    {
        $this->setCacheDir(sys_get_temp_dir());
    }

    // {{{ setCacheDir()

    /**
     * Sets the directory in which cache files are stored
     *
     * @param string $cacheDir the directory in which cache files are stored.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setCacheDir($cacheDir)
    {
        $this->cacheDir  = rtrim((string)$cacheDir, DIRECTORY_SEPARATOR);
        $this->cacheDir .= DIRECTORY_SEPARATOR;
        return $this;
    }

    // }}}
    // {{{ setLifeTime()

    /**
     * Sets the cache life-time in seconds
     *
     * Values saved after the life-time is set will expire after life-time
     * seconds.
     *
     * @param integer $lifeTime the cache life-time in seconds.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setLifeTime($lifeTime)
    {
        $this->lifeTime = (integer)$lifeTime;
        return $this;
    }

    // }}}
    // {{{ setFileLocking()

    /**
     * Sets whether or not file locking is enabled
     *
     * File locking can avoid cache corruption under bad circumstances.
     *
     * @param boolean $locking whether or not file locking is enabled.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setFileLocking($locking)
    {
        $this->fileLocking = ($locking) ? true : false;
        return $this;
    }

    // }}}
    // {{{ setWriteControl()

    /**
     * Sets whether or not write control is enabled
     *
     * When write control is enabled, the cache is read immediately after
     * every write operation. Enabling write control will slow the cache
     * down slightly only when saving cache values. Write control can
     * detect some corrupt cache files.
     *
     * @param boolean $writeControl whether or not write control is enabled.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setWriteControl($writeControl)
    {
        $this->writeControl = ($writeControl) ? true : false;
        return $this;
    }

    // }}}
    // {{{ setReadControl()

    /**
     * Sets whether or not read control is enabled
     *
     * When read control is enabled, a hash value is embedded in each cache
     * file. The value is compared with a calculated hash value when the
     * cache file is read.
     *
     * @param boolean $readControl whether or not read control is enabled.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setReadControl($readControl)
    {
        $this->readControl = ($readControl) ? true : false;
        return $this;
    }

    // }}}
    // {{{ setReadControlType()

    /**
     * Sets the read control hash type
     *
     * Must be one of:
     * - <kbd>md5</kbd>    - best, but slowest
     * - <kbd>crc32</kbd>  - slightly less safe, but faster (default)
     * - <kbd>strlen</kbd> - fastest, but less likely to detect errors
     *
     * @param string $readControlType the type to set. Must be a valid type.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     *
     * @throws \PEAR2\Cache\Lite\InvalidHashTypeException if the specified
     *         <kbd>$readControlType</kbd> is not a valid hash type.
     */
    public function setReadControlType($readControlType)
    {
        static $validTypes = array(
            'md5',
            'crc32',
            'strlen',
        );
        if (!in_array($readControlType, $validTypes)) {
            throw new InvalidHashTypeException(
                'Read control type \'' . $readControlType . '\' is not valid.',
                0,
                $readControlType
            );
        }
        $this->readControlType = $readControlType;
        return $this;
    }

    // }}}
    // {{{ setFileNameProtection()

    /**
     * Sets whether or not file name protection is enabled
     *
     * When file name protection is enabled, the cache key id and group
     * can contain any characters. When filename protection is not enabled,
     * the key id and group are used directly in filenames and may not
     * contain invalid filename characters.
     *
     * @param boolean $fileNameProtection whether or not file name protection
     *                                    is enabled.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setFileNameProtection($fileNameProtection)
    {
        $this->fileNameProtection = ($fileNameProtection) ? true : false;
        return $this;
    }

    // }}}
    // {{{ setAutomaticCleaningFactor()

    /**
     * Sets the level of automatic cleaning to use
     *
     * The automatic cleaning process destroys expired files when a new file
     * is written.
     *
     * - <kbd>0</kbd> - no automatic cleaning is performed
     * - <kbd>1</kbd> - cleaning is always performed
     * - <kbd>n</kbd> - cleaning is performed randomly with a probability
     *                  of 1 / n for each cache write.
     *
     * @param integer $automaticCleaningFactor the level of automatic cleaning
     *                                         to use.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setAutomaticCleaningFactor($automaticCleaningFactor)
    {
        $this->automaticCleaningFactor = (integer)$automaticCleaningFactor;
        return $this;
    }

    // }}}
    // {{{ setNestedDirectoryLevel()

    /**
     * Sets the nested directory level to use
     *
     * Nested directories can improve performance for large caches on certain
     * filesystems. Nested directories effectively reduce the number of files
     * per directory.
     *
     * - <kbd>0</kbd> - no nested directories
     * - <kbd>n</kbd> - use n levels of nested directories
     *
     * @param integer $nestedDirectoryLevel the nested directory level to use.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setNestedDirectoryLevel($nestedDirectoryLevel)
    {
        $this->nestedDirectoryLevel = (integer)$nestedDirectoryLevel;
        return $this;
    }

    // }}}
    // {{{ setNestedDirectoryUmask()

    /**
     * Sets the umask to use for nested directories
     *
     * If nested directories are enabled, this controls the umask set for
     * new directories.
     *
     * @param integer $nestedDirectoryUmask the umask to use for new directies
     *                                      created by the nested directories
     *                                      system.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function setNestedDirectoryUmask($nestedDirectoryUmask)
    {
        $this->nestedDirectoryUmask = (integer)$nestedDirectoryUmask;
        return $this;
    }

    // }}}
    // {{{ get()

    /**
     * Gets a cached value
     *
     * @param string  $id           cache id.
     * @param string  $group        optional. Cache group. If not specified,
     *                              'default' is used.
     * @param boolean $testValidity optional. Whether or not to check the
     *                              validity of cached data. If false, expired
     *                              data may be returned.
     *
     * @return string|boolean the cached data or false if it does not exist in
     *                        the cache.
     *
     * @throws \PEAR2\Cache\Lite\FileException if there is an error reading the
     *         cache file.
     */
    public function get($id, $group = 'default', $testValidity = true)
    {
        $data = false;

        $refreshTime = $this->getRefreshTime();
        $filePath    = $this->getFilePath($id, $group);

        clearstatcache();

        if (!$testValidity || $refreshTime === 0) {
            if (file_exists($filePath)) {
                $data = $this->read($filePath);
            }
        } else {
            if (file_exists($filePath) && filemtime($filePath) > $refreshTime) {
                $data = $this->read($filePath);
            }
        }

        return $data;
    }

    // }}}
    // {{{ save()

    /**
     * Saves a cached value
     *
     * @param string  $data  the data to cache.
     * @param string  $id    cache id.
     * @param string  $group optional. Cache group. If not specified, 'default'
     *                       is used.
     *
     * @return boolean true if the data was cached successfully, otherwise
     *                 false.
     *
     * @throws \PEAR2\Cache\Lite\FileException if there is an error writing the
     *         cache file.
     */
    public function save($data, $id, $group = 'default')
    {
        $success = false;

        if (   $this->automaticCleaningFactor > 0
            && ($this->automaticCleaningFactor === 1
            || mt_rand(1, $this->automaticCleaningFactor) === 1)
        ) {
            $this->cleanOld();
        }

        $filePath = $this->getFilePath($id, $group);

        if ($this->writeControl) {
            $success = $this->writeAndControl($filePath, $data);
            if (!$success) {
                touch($filePath, time() - 2 * $this->lifeTime);
            }
        } else {
            $success = $this->write($filePath, $data);
        }

        return $success;
    }

    // }}}
    // {{{ remove()

    /**
     * Clears a cached value
     *
     * @param string $id    the cache id.
     * @param string $group optional. The cache group. If not specified,
     *                      'default' is used.
     *
     * @throws \PEAR2\Cache\Lite\FileException if there is an error deleting
     *         the cache file.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     */
    public function remove($id, $group = 'default')
    {
        $filePath = $this->getFilePath($id, $group);

        if (file_exists($filePath)) {
            $this->unlink($filePath);
        }

        return $this;
    }

    // }}}
    // {{{ removeGroup()

    /**
     * Clears all cached values for a group
     *
     * @param string $group the group to clear.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     *
     * @throws \PEAR2\Cache\Lite\FileException if there is an error deleting
     *         a cache file.
     */
    public function removeGroup($group)
    {
        if ($this->fileNameProtection) {
            $motif = ($group) ? 'cache_' . md5($group) . '_' : 'cache_';
        } else {
            $motif = ($group) ? 'cache_' . $group . '_' : 'cache_';
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->cacheDir),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $path) {
            if ($path->isFile()) {
                $fileName = $path->getFilename();
                if (strncmp($fileName, $motif, strlen($motif)) === 0) {
                    $this->unlink($path->getPathname());
                }
            }
        }

        return $this;
    }

    // }}}
    // {{{ cleanOld()

    /**
     * Cleans up old files in the cache directory
     *
     * Cache files that have expired are deleted.
     *
     * @return \PEAR2\Cache\Lite the current object, for fluent interface.
     *
     * @throws \PEAR2\Cache\Lite\FileException if there is an error deleting
     *         a cache file.
     */
    public function cleanOld()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->cacheDir),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $path) {
            if (   $path->isFile()
                && strncmp($path->getFilename(), 'cache_', 6) === 0
                && $lifeTime > 0
                && time() - $path->getMTime() > $this->lifeTime
            ) {
                $this->unlink($path->getPathname());
            }
        }

        return $this;
    }

    // }}}

    public function extendLife($id, $group = 'default')
    {
        $filePath = $this->getFilePath($id, $group);
        touch($filePath);
        return $this;
    }

    public function getRefreshTime()
    {
        $refreshTime = 0;

        if ($this->lifeTime > 0) {
            $refreshTime = time() - $this->lifeTime;
        }

        return $refreshTime;
    }

    protected function getFileName($id, $group)
    {
        $key = $id . '-' . $group;

        if (!isset($this->fileNames[$key])) {
            if ($this->fileNameProtection) {
                $this->fileNames[$key] = 'cache_' . md5($group) . '_' . md5($id);
            } else {
                $this->fileNames[$key] = 'cache_' . $group . '_' . $id;
            }
        }

        return $this->fileNames[$key];
    }

    protected function getFilePath($id, $group)
    {
        $key = $id . '-' . $group;

        if (!isset($this->filePaths[$key])) {
            $fileName = $this->getFileName($id, $group);
            $dir = $this->cacheDir;
            if ($this->nestedDirectoryLevel > 0) {
                $hash = md5($fileName);
                for ($i = 0; $i < $this->nestedDirectoryLevel; $i++) {
                    $dir .= 'cache_' . substr($hash, 0, $i + 1) . '/';
                }
            }
            $this->filePaths[$key] = $dir . $fileName;
        }

        return $this->filePaths[$key];
    }

    protected function unlink($filePath)
    {
        if (!unlink($filePath)) {
            throw new FileException(
                'Unable to remove cache file \'' . $filePath . '\'.',
                0,
                $filePath
            );
        }
    }

    protected function read($filePath)
    {
        $data = false;

        $fp = fopen($filePath, 'rb');
        if ($fp === false) {
            throw new FileException(
                'Unable to read cache file \'' . $filePath . '\'.',
                0,
                $filePath
            );
        }

        if ($this->fileLocking) {
            flock($fp, LOCK_SH);
        }

        clearstatcache();
        $length = filesize($filePath);

        if ($this->readControl) {
            $hashControl = fread($fp, 32);
            $length = $length - 32;
        }

        if ($length > 0) {
            $data = fread($fp, $length);
        } else {
            $data = '';
        }

        if ($this->fileLocking) {
            flock($fp, LOCK_UN);
        }

        fclose($fp);

        if ($this->readControl) {
            $hashData = $this->hash($data, $this->readControlType);
            if ($hashData != $hashControl) {
                if ($this->lifeTime > 0) {
                    touch($filePath, time() - 2 * $this->lifeTime);
                } else {
                    $this->unlink($filePath);
                }
                $data = false;
            }
        }

        return $data;
    }

    protected function write($filePath, $data)
    {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, $this->nestedDirectoryUmask, true);
        }

        $fp = fopen($filePath, 'wb');

        if ($fp === false) {
            throw new FileException(
                'Unable to write cache file \'' . $filePath . '\'.',
                0,
                $filePath
            );
        }

        if ($this->fileLocking) {
            flock($fp, LOCK_EX);
        }

        if ($this->readControl) {
            fwrite($fp, $this->hash($data, $this->readControlType), 32);
        }

        fwrite($fp, $data);

        if ($this->fileLocking) {
            flock($fp, LOCK_UN);
        }

        fclose($fp);

        return true;
    }

    protected function writeAndControl($filePath, $data)
    {
        $this->write($filePath, $data);
        $dataRead = $this->read($filePath);
        return ($dataRead === $data);
    }

    // {{{ hash()

    /**
     * Hashes data using the specified hash type
     *
     * Valid hash control types are:
     * - <kbd>md5</kbd>
     * - <kbd>crc32</kbd>
     * - <kbd>strlen</kbd>
     *
     * @param string $data        the data to hash.
     * @param string $controlType the hash method to use. Must be a valid hash
     *                            control type.
     *
     * @return string a 32-character string containing the hashed data.
     *
     * @throws \PEAR2\Cache\Lite\InvalidHashTypeException if the specified
     *         <kbd>$controlType</kbd> is invalid.
     */
    protected function hash($data, $controlType = 'crc32')
    {
        switch ($controlType) {
        case 'md5':
            return md5($data);
        case 'crc32':
            return sprintf('% 32d', crc32($data));
        case 'strlen':
            return sprintf('% 32d', strlen($data));
        default:
            throw new InvalidHashTypeException(
                'Invalid hash control type. Valid types are: \'md5\', '
                . '\'crc32\', and \'strlen\'',
                0,
                $controlType
            );
        }
    }

    // }}}
}
