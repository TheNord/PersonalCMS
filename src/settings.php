<?php

// Settings

chdir(dirname(__DIR__));

$configs = array_map(
    function ($file) {
        return require $file;
    },
    glob(__DIR__ . '/settings/{{,*.}}php', GLOB_BRACE)
);

return array_merge_recursive(...$configs);