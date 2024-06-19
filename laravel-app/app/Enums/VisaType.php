<?php

namespace App\Enums;

enum VisaType: string {
    case BUSINESS = 'business';
    case TOURIST = 'tourist';
    case WORKPERMIT = 'work-permit';
    case EMPLOYMENT = 'employment';
    case RESEARCH = 'research';
    case CONFERENCE = 'conference';
    case ENTRY = 'entry';
    case MEDICAL = 'medical';
    case STUDENT = 'student';
}