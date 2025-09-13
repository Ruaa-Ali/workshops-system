<?php

namespace App\Enums;

enum PermissionsTypes: string
{
    case MANAGE_WORKSHOPS = "manage workshops";
    case MANAGE_OFFERINGS = "manage offerings";
    case VIEW_WORKSHOPS = "view workshops";
    case VIEW_ENROLLMENTS = "view enrollments";
    case VIEW_STATS = "view stats";
    case MANAGE_USERS = "manage users";
    case VIEW_CLASSES = "view classes";
    case ENROLL_TO_CLASSES = "enroll to classes";
}
