<?php

return [
    'default_region' => 'ap-northeast-1',
    'default_region_s3' => 'us-east-1',
    'master_account' => [
        'id' => env('AWS_MASTER_ACCOUNT_ID'),
        'key' => env('AWS_MASTER_ACCOUNT_KEY'),
        'secret' => env('AWS_MASTER_ACCOUNT_SECRET'),
    ],
    'cloud_formation_creation_link' => 'https://ap-northeast-1.console.aws.amazon.com/cloudformation/home#/stacks/quickcreate',
    'cloud_formation_template_link' => 'https://cf-templates-12gpx1h4fsiv-ap-northeast-1.s3-ap-northeast-1.amazonaws.com/20210506-SunnyviewResellerAccountRole.yml',
];
