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
                'passed' => 'Passed',
            ],
            'questions' => [
                'input' => 'Short Text or Number',
                'date' => 'Date',
                'select' => 'Dropdown',
                'checkbox' => 'Multiple Checkboxes',
                'textarea' => 'Paragraph',
                'radio' => 'Radio Buttons',
            ],
        ],
    ],
];
