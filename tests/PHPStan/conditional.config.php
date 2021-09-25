<?php
declare(strict_types = 1);

use PhpParser\Node\VariadicPlaceholder;

$config = [];

if (! class_exists(VariadicPlaceholder::class)) {
     // VariadicPlaceholder supported since nikic/php-parser 4.13
    $config['parameters']['ignoreErrors'][] = '~Class PhpParser\\\\Node\\\\VariadicPlaceholder not found~';
}

return $config;
