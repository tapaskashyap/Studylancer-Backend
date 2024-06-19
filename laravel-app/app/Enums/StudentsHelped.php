<?php

namespace App\Enums;

enum StudentsHelped: string {
    case FIRST = '0-100';
    case SECOND = '100-200';
    case THIRD = '200-300';
    case FOURTH = '300-400';
    case FIFTH = '400+';
}