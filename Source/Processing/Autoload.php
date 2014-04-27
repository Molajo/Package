<?php
/**
 * Local Processing Autoload
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$processing_base = substr(__DIR__, 0, strlen(__DIR__) - 17);

$processing_classmap = array();
$processing_classmap['Molajo\\Reflection\\Source'] = $processing_base . '/Source/Source.php';

spl_autoload_register(
    function ($class) use ($processing_classmap) {
        if (array_key_exists($class, $processing_classmap)) {
            require_once $processing_classmap[$class];
        }
    }
);
