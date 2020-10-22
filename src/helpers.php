<?php

namespace Develtio\WP\ThemeSettings;

use StoutLogic\AcfBuilder\FieldsBuilder;

function getFieldPartial(string $partial): FieldsBuilder
{
    $partial = str_replace('.', '/', $partial);

    return include(__DIR__ . "/acf/{$partial}.php");
}