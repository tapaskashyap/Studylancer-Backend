<?php

namespace App\Enums;

enum VisaOutcome: string {
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}