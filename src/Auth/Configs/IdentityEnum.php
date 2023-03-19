<?php

namespace Domain\Auth\Configs;

enum IdentityEnum: string
{
    case EMAIL = 'email';
    case USERNAME = 'username';
    case EMAIL_USERNAME = 'email-username';
}
