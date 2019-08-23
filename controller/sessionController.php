<?php
class Session
{
    public static function getUserId()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            return $_SESSION['user_id'];
        }
        else {
            return 0;
        }
    }

    public static function getUserPseudo()
    {
        if (isset($_SESSION['pseudo'])) {
            return $userRole = $_SESSION['pseudo'];
        }
        else {
            return NULL;
        }
    }

    public static function getUserRole()
    {
        if (isset($_SESSION['role'])) {
            return $userRole = $_SESSION['role'];
        }
        else {
            return NULL;
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
