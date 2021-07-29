<?php

return [
    'driver_path' => storage_path('app'),
    'kakao_login' => [
        'confirm_btn' => [
            'className' => 'confirm',
            'action' => 'click',
            'parameters' => []
        ],
        'link_kakao_id' => [
            'className' => 'link_kakao_id',
            'action' => 'click',
            'parameters' => []
        ],
        'email_input' => [
            'id' => 'id_email_2',
            'action' => 'sendKeys',
            'parameter' => env('KAKAO_ACCOUNT')
        ],
        'pass_input' => [
            'id' => 'id_password_3',
            'action' => 'sendKeys',
            'parameter' => env('KAKAO_PASSWORD')
        ],
        'login_submit' => [
            'className' => 'submit',
            'action' => 'click',
            'parameters' => []
        ]
    ]
];
