<?php

return [
    'Survey' => [
        'Categories' => [
            ['name' => 'Default', 'value' => 'default'],
            ['name' => 'Marketing', 'value' => 'marketing'],
        ],
        'Options' => [
            'submitViaPreview' => true,
            'statuses' => [
                'sent' => 'Sent',
                'received' => 'Received',
                'in_review' => 'In Review',
                'rejected' => 'Rejected',
                'failed' => 'Failed',
                'passed' => 'Passed'
            ]
        ]
    ],
];
