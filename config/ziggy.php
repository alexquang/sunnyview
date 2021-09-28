<?php

return [
    'groups' => [
        'admin' => ['admin.*'],
        'frontend' => ['frontend.*'],
    ],
    'except' => [
        '_debugbar.*', 'horizon.*',
    ],
];
