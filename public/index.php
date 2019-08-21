<?php
require ('../controller/frontend.php');
require ('../controller/backend.php');
require ('../controller/sessionController.php');


try {
    session_start();
    /*
    * Manage posts and comments view using frontend controller and backend controller to insert/update/delete from db
    */
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'list_posts') {
            if (isset($_GET['type'])) {
                if ($_GET['type'] == 'chapter' OR $_GET['type'] == 'announcement' OR $_GET['type'] == 'general') {
                    listPosts($_GET['type']);
                }
                else {
                    listPosts($type = NULL);
                }
            }
            else {
                listPosts($type = NULL);
            }
        }
        elseif ($_GET['action'] == 'post')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                post($_GET['id']);
            }
            else {
                throw new Exception('Aucun idenditifiant de billet envoyé');
            }
        }
        // Will use backend controller to manage db
        elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['title']) && !empty($_SESSION['user_id']) && !empty($_POST['content'])) {
                    addComment($_GET['id'], $_POST['title'], $_SESSION['user_id'], $_POST['content']);
                }
                else {
                    throw new Exception('Tous les champs ne sont pas remplis.');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'comment_edit' && isset($_SESSION['user_id']))
        {
            if (isset($_GET['id']) && $_GET['id'] > 0)
            {
                updateComment($_GET['id'], $_SESSION['user_id']);
            }
            else {
                throw new Exception('Aucun identifiant de commentaires envoyé');
            }
        }
        elseif ($_GET['action'] == 'comment_updated')
        {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (isset($_GET['id_comment']) && $_GET['id_comment'] > 0) {
                    if (!empty($_POST['title']) && !empty($_SESSION['user_id']) && !empty($_POST['content'])) {
                        updatedComment($_GET['id_comment'], $_SESSION['user_id'], $_POST['title'], $_POST['content']);
                    }
                    else {
                        throw new Exception('Tous les champs ne sont pas remplis.');
                    }
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'delete_comment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_SESSION['user_id'])) {
                    deleteComment($_SESSION['user_id'], $_GET['id']);
                }
                else {
                    throw new Exception('Vous n\'avez pas l\'autorisation requise');
                }
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        elseif ($_GET['action'] == 'report') {
            if (isset($_SESSION['user_id']) && isset($_GET['id']) && $_GET['id'] > 0) {
                report($_GET['id'], $_SESSION['user_id']);
            }
            else {
                throw new Exception('Aucun identifiant de billet envoyé');
            }
        }
        /*
        * User management using controller frontend to set up the views and backend for insert to db
        */
        elseif ($_GET['action'] == 'registration')
        {
            if ($_GET['sent'] == 'no') {
                registration();
            }
            elseif ($_GET['sent'] == 'yes')
            {
                if (!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['password']) && !empty($_POST['confirm_password']))
                {
                    if ($_POST['password'] == $_POST['confirm_password'])  {
                        addUser($_POST['pseudo'], $_POST['password'], $_POST['mail']);
                    }
                    else
                    {
                        throw new Exception('Merci de confirmer le mot de passe.');
                    }
                }
                else {
                    throw new Exception('Veuillez remplir les informations requises pour l\'inscription');
                }
            }
            else {
                registration();
            }
        }
        elseif ($_GET['action'] == 'registered') {
            registered();
        }
        elseif ($_GET['action'] == 'connect') {
            if (!empty($_POST['pseudo']) && !empty($_POST['password']))
            {
                connection($_POST['pseudo'], $_POST['password']);
            }
            else
            {
                throw new Exception('Merci de renseigner un pseudo et un mot de passe valide.');
            }
        }
        elseif ($_GET['action'] == 'disconnect')
        {
            disconnect();
        }
        elseif ($_GET['action'] == 'user_profile') {
            if (isset($_SESSION['user_id'])) {
                userProfile($_SESSION['user_id']);
            }
            else {
                throw new Exception('Vous n\'êtes pas connecté.');
            }
        }
        elseif ($_GET['action'] == 'update_mail') {
            if (isset($_SESSION['user_id']) && !empty($_POST['mail']) && !empty($_POST['password'])) {
                updateMail($_SESSION['user_id'], $_POST['mail'], $_POST['password']);
            }
            else {
                throw new Exception('Merci remplir tous les champs.');
            }
        }
        elseif ($_GET['action'] == 'update_password') {
            if (isset($_SESSION['user_id']) && !empty($_POST['password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_new_password'])) {
                if ($_POST['new_password'] == $_POST['confirm_new_password']) {
                    updatePassword($_SESSION['user_id'], $_POST['password'], $_POST['new_password']);
                }
                else {
                    throw new Exception('Merci de vérifier les informations que vous avez saisi.');
                }
            }
            else {
                throw new Exception('Merci remplir tous les champs.');
            }
        }
        /*
        * Control session role. If admin is set up, grant privileges to admin pannel
        */
        // Writer, Editor, Admin
        elseif ($_GET['action'] == 'new') {
            if (Session::hasWriteAccess()) {
                newPost();
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'addPost') {
            if (Session::hasWriteAccess()) {
                if (isset($_POST['type']) && isset($_POST['title']) && isset($_POST['content'])) {
                    if ($_POST['type'] != 'NULL') {
                    addPost($_SESSION['user_id'], $_POST['type'], $_POST['title'], $_POST['content']);
                    }
                    else {
                        throw new Exception('Merci de choisir un type de billet.');
                    }
                }
                else {
                    throw new Exception('Merci de remplir tous les champs.');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
// TODO
        elseif ($_GET['action'] == 'update_list_my_posts') {
            if (Session::hasWriteAccess()) {
                $allPosts = false;
                if (isset($_GET['type'])) {
                    if ($_GET['type'] == 'chapter' OR $_GET['type'] == 'announcement' OR $_GET['type'] == 'general') {
                        updateListPosts($allPosts, $_GET['type']);
                    }
                    else {
                        updateListPosts($allPosts, $type = NULL);
                    }
                }
                else {
                    updateListPosts($allPosts, $type = NULL);
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'updatePost') {
            if (Session::hasWriteAccess()) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    updatePost($_GET['id']);
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'updatedPost') {
            if (Session::hasWriteAccess()) {
                if (!empty($_POST['post_id']) && !empty($_POST['type']) && !empty($_POST['title']) && !empty($_POST['content'])) {
                    updatedPost($_POST['post_id'], $_POST['type'], $_POST['title'], $_POST['content']);
                }
                else {
                    throw new Exception('Merci de remplir tous les champs.');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        // Editor and Admin
        elseif ($_GET['action'] == 'update_list_posts') {
            if (Session::hasEditionAccess()) {
                $allPosts = true;
                if (isset($_GET['type'])) {
                    if ($_GET['type'] == 'chapter' OR $_GET['type'] == 'announcement' OR $_GET['type'] == 'general') {
                        updateListPosts($allPosts, $_GET['type']);
                    }
                    else {
                        updateListPosts($allPosts, $type = NULL);
                    }
                }
                else {
                    updateListPosts($allPosts, $type = NULL);
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'delete_post') {
            if (Session::hasEditionAccess()) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_SESSION['user_id'])) {
                        deletePost($_SESSION['user_id'], $_GET['id']);
                    }
                    else {
                        throw new Exception('Vous n\'avez pas l\'autorisation requise');
                    }
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        // Moderator and Admin
        elseif ($_GET['action'] == 'moderation') {
            if (Session::hasModerationAccess()) {
                moderation();
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'ignore') {
            if (Session::hasModerationAccess()) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    ignoreComment($_GET['id']);
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'delete_reported') {
            if (Session::hasModerationAccess()) {
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    deleteReported($_GET['id']);
                }
                else {
                    throw new Exception('Aucun identifiant de billet envoyé');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == 'users_list') {
            if (Session::hasModerationAccess()) {
                usersList();
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        elseif ($_GET['action'] == "delete_user") {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if ($_SESSION['role'] == 'admin') {
                    deleteUser($_GET['id']);
                }
                elseif ($_SESSION['role'] == 'moderator') {
                    deleteCommonUser($_GET['id']);
                }
                else {
                    throw new Exception('Vous n\'avez pas l\'autorisation requise');
                }
            }
            else {
                throw new Exception('Aucun identifiant envoyé');
            }
        }
        // Admin
        elseif ($_GET['action'] == 'update_role') {
            if (Session::hasAdminAccess()) {
                if (!empty($_POST['user_id']) && $_POST['user_id'] > 0 && !empty($_POST['role'])) {
                    updateRole($_POST['user_id'], $_POST['role']);
                }
                else {
                    throw new Exception('Aucune donnée de formulaire envoyée');
                }
            }
            else {
                throw new Exception('Vous n\'avez pas l\'autorisation requise');
            }
        }
        else {
            listPosts($type = NULL);
        }
    }
    else {
        listPosts($type = NULL);
    }
} catch (Exception $e) {
    $errorMessage = $e->getMessage();
    require('../view/errorView.php');
}
