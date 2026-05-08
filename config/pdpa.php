<?php

return [
    'roles' => [
        'admin' => 'Administrator',
        'staff' => 'Staff Member',
        'viewer' => 'Viewer',
    ],

    'data_categories' => [
        'personal' => 'Personal Information',
        'financial' => 'Financial Information',
        'health' => 'Health Information',
        'employment' => 'Employment Information',
        'other' => 'Other',
    ],

    'record_status' => [
        'active' => 'Active',
        'archived' => 'Archived',
        'pending_deletion' => 'Pending Deletion',
    ],

    'consent_status' => [
        'given' => 'Given',
        'withdrawn' => 'Withdrawn',
        'pending' => 'Pending',
    ],

    'lawful_basis' => [
        'consent' => 'Consent',
        'contract' => 'Contract Performance',
        'legal_obligation' => 'Legal Obligation',
        'vital_interests' => 'Vital Interests',
        'public_task' => 'Public Task',
        'legitimate_interests' => 'Legitimate Interests',
    ],

    'request_types' => [
        'access' => 'Right to Access',
        'deletion' => 'Right to Be Forgotten',
        'rectification' => 'Right to Rectification',
        'portability' => 'Data Portability',
        'restrict_processing' => 'Restrict Processing',
        'object_processing' => 'Object to Processing',
    ],

    'request_status' => [
        'pending' => 'Pending',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'rejected' => 'Rejected',
        'withdrawn' => 'Withdrawn',
    ],

    'data_retention_days' => 365,
    'request_deadline_days' => 30,
    'retention_expiry_warning_days' => 30,
];
