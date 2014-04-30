<?php
/**
 * Bootstrap for Testing
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

include_once __DIR__ . '/Autoload.php';
//include_once __DIR__ . '/Packages.php';

//foreach ($packages as $package => $package_base) {
//    include_once $package_base . '/.dev/Bootstrap.php';
//    $class = 'Molajo\\Reflection\\Source';
//    $source = new $class();
//    $data = $source->process($package_base, $classmap, 'Molajo', $package);
//}

$class = 'Molajo\\Reflection\\Categorize';
$source = new $class();
$data = $source->process();