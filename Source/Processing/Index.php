<?php
/**
 * Bootstrap for Testing
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
$project = 'Molajo';
$package = 'User';

include_once __DIR__ . '/Autoload.php';
include_once __DIR__ . '/Packages.php';
$package_base = $packages[$package];
include_once $package_base . '/.dev/Bootstrap.php';  // $classmap

$class = 'Molajo\\Reflection\\Source';
$source = new $class();
$data = $source->process($package_base, $classmap, $project, $package);
