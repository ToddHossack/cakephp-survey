<?php

return [
    'Survey' => [
        'Categories' => [
            ['name' => 'Default', 'value' => 'default'],
            ['name' => 'Marketing', 'value' => 'marketing'],
        ],
        'Options' => [
            'submitViaPreview' => true,
            'entryTypes' => [
                'received' => 'Received',
                'in_review' => 'In Review',
                'cancelled' => 'Cancelled',
                'failed' => 'Failed',
                'passed' => 'Passed'
            ]
        ]
    ],
];
