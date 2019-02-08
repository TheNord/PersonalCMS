<?php

// DIC configuration

$configuration = array_map(
    function ($file) {
        return require $file;
    },
    glob(__DIR__ . '/configuration/{{,*.}}php', GLOB_BRACE)
);

$dependencies = array_merge_recursive(...$configuration);

return $dependencies;