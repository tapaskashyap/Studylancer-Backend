<?php

namespace App\Enums;

enum MaritalStatus: string {
    case MARRIED = 'married';
    case UNMARRIED = 'unmarried';
    case DIVORCED = 'divorced';
    case WIDOWED = 'widowed';
}