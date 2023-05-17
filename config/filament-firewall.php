<?php

use SolutionForest\FilamentFirewall\Models\Ip;

return [
    'models' => [
        'ip' => Ip::class,
    ],
    'skip_whitelist_range' => [
        '127.0.0.1',
    ],
];