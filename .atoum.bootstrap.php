<?php

use Go\Aop\Features;
use Rezzza\TimeTravelerAspectKernel;

require_once  __DIR__.'/vendor/autoload.php';



// Initialize an application aspect container
$applicationAspectKernel = TimeTravelerAspectKernel::getInstance();
$defaultFeatures = TimeTravelerAspectKernel::getDefaultFeatures();
$cacheDirectory = __DIR__ . '/tests/units/cache/go-aop';

if (!is_dir($cacheDirectory) && strlen($cacheDirectory) > 0) {
    mkdir($cacheDirectory, 0700, true);
}

$applicationAspectKernel->init(array(
    'debug' => true, // use 'false' for production mode
    // Cache directory
    'cacheDir' => $cacheDirectory,
    // Include paths restricts the directories where aspects should be applied, or empty for all source files
    'includePaths' => array(
//                __DIR__ . '/tests/units'
    ),
    // Enable function interception
//            'interceptFunctions' => true,
    'features' => $defaultFeatures | Features::INTERCEPT_FUNCTIONS,
));
