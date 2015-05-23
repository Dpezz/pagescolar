<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$loader->add('Ps', __DIR__.'/../vendor');
$loader->add('PHPPdf', __DIR__.'/../vendor/Ps/PHPPdf/lib');
$loader->add('Markdown', __DIR__.'/../vendor/Ps/PHPPdf/lib/vendor');
$loader->add('Imagine', array(__DIR__.'/../vendor/Ps/PHPPdf/lib/vendor', __DIR__.'/../vendor/Ps/PHPPdf/lib/vendor/Imagine/lib'));
$loader->add('Zend', __DIR__.'/../vendor/Ps/PHPPdf/lib/vendor/Zend/library');
$loader->add('ZendPdf', __DIR__.'/../vendor/Ps/PHPPdf/lib/vendor/ZendPdf/library');

return $loader;
