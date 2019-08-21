<?php
class Session
{
    public static function getUserId()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            return $userId = $_SESSION['user_id'];
        }
        else {
            return $userId = 0;
        }
    }

    public static function getUserRole()
    {
        if (isset($_SESSION['role'])) {
            return $userRole = $_SESSION['role'];
        }
        else {
            return $userRole = NULL;
        }
    }

    public static function hasWriteAccess()
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor' OR $_SESSION['role'] == 'writer') {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    public static function hasEditionAccess()
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'editor') {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    public static function hasModerationAccess()
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'admin' OR $_SESSION['role'] == 'moderator') {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    public static function hasAdminAccess()
    {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'admin') {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
}
