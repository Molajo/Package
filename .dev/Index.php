<?php
/**
 * Automate Project Documentation using Source Data
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */

include __DIR__ . '/Bootstrap.php';

$base_path   = substr(__DIR__, 0, strlen(__DIR__) - 5);

$class = 'Molajo\\Reflection\\Source';
$source = new $class();
$data = $source->process($base_path, $classmap, 'Molajo', 'Fieldhandler');
