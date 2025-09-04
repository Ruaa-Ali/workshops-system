<?php

namespace App\Enums;

enum LocalRole: string
{
    case ADMIN = "admin";
    case TEACHER = "teacher";
    case STUDENT = "student";
}
