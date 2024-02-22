<?php

namespace App\Enums;

enum UserType: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case AGENT = 'agent';
    case LENDER = 'lender';
}
