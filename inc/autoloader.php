<?php
/**
 * This file is part of JKHighlightResume
 *
 * (c) 2024 James Kinsman relipse@gmail.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.

 * @copyright 2024 Jim Kinsman
 * @license MIT
 */
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/classes/' . str_replace('\\',DIRECTORY_SEPARATOR,$class_name) . '.php';

    if (file_exists($file)) {
        require_once($file);
    }
});
