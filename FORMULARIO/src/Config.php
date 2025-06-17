<?php

namespace App;

class Config {
    public const DATA_FILE = __DIR__ . '/../data/submissions.json';

    public const FUNCS = [
        'CU001' => 'User Registration',
        'CU002' => 'User Login',
        'CU003' => 'Profile Update',
        'CU004' => 'Password Reset',
        'CU005' => 'Data Search',
    ];
}
