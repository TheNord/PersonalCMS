<?php

// Settings

use Symfony\Component\Dotenv\Dotenv;

chdir(dirname(__DIR__));

if (file_exists('.env')) {
    (new Dotenv())->load('.env');
} else {
    throw new \Exception('You need to configure the env file');
}

$configs = array_map(
    function ($file) {
        return require $file;
    },
    glob(__DIR__ . '/settings/{{,*.}}php', GLOB_BRACE)
);

return array_merge_recursive(...$configs);