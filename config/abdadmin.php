<?php

return [

    'authentication' => [

        /**
            * - regular
            * - stepped
            */
        'flow_type' => 'regular',

        /**
            * - email
            * - username
            * - email-username
            */
        'identity' => 'email',

        'verification' => ['password', '2fa'],

        '2fa_options' => ['email', 'authcode', 'push', 'sms'],

    ],

];
