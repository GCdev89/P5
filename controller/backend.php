<?php
/*
* Manage interactions with the DB, create/update/delete
*/
require_once('../model/PostManager.php');
require_once('../model/CommentManager.php');
require_once('../model/UserManager.php');
/*
* Insert & update user's info into db
*/
function addUser($pseudo, $password, $mail)
{
    $hashPass = password_hash($password, PASSWORD_DEFAULT);
    $role = 'common_user'; // every new user is by default set as common_user
    $data = [
        'role' => $role,
        'pseudo' => $pseudo,
        'password' => $hashPass,
        'mail' => $mail
    ];
    $userManager = new Gaetan\P5\Model\UserManager();

    if (!$userManager->pseudoExists($_POST['pseudo']) && !$userManager->mailExists($_POST['mail'])) {
        $user = new Gaetan\P5\Model\User($data);
        $affectedLines = $userManager->add($user);
        if ($affectedLines == false) {
            throw new Exception('Impossible d\'enregistrer l\'utilisateur');
        }
        else {
            $userConnected = $userManager->getUser($pseudo);
            $_SESSION['user_id'] = $userConnected->id();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['role'] = $userConnected->role();

            header('Location: index.php?action=registered');
        }
    }
    else {
        throw new Exception('Ces identifiants ne sont pas disponnibles, merci d\'en choisir un autre ');
    }
}

function updateMail($userId, $mail, $password)
{
    $userManager = new Gaetan\P5\Model\UserManager();
    if ($userManager->exists($userId)) {
        if (!$userManager->mailExists($mail)) {
            $user = $userManager->getUser($userId);
            $isPasswordCorrect = password_verify($password, $user->password());

            if ($isPasswordCorrect) {
                $data = ['id' => $userId, 'mail' => $mail];
                $userUpdated = new Gaetan\P5\Model\User($data);
                $affectedLines = $userManager->updateMail($userUpdated);
                if ($affectedLines == false) {
                    throw new Exception('Impossible de modifier le mail.');
                }
                else {
                    header('Location: index.php?action=user_profile');
                }
            }
            else {
                throw new Exception('Mauvais identifiant ou mot de passe');
            }
        }
        else {
            throw new Exception('Ces identifiants ne sont pas disponnibles, merci d\'en choisir un autre ');
        }
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

function updatePassword($userId, $password, $newPassword)
{
    $userManager = new Gaetan\P5\Model\UserManager();
    if ($userManager->exists($userId)) {
        $user = $userManager->getUser($userId);

        $isPasswordCorrect = password_verify($password, $user->password());
        if ($isPasswordCorrect) {
            $hashPass = password_hash($newPassword, PASSWORD_DEFAULT);
            $data = ['id' => $userId, 'password' => $hashPass];
            $userUpdated = new Gaetan\P5\Model\User($data);
            $affectedLines = $userManager->updatePassword($userUpdated);
            if ($affectedLines == false) {
                throw new Exception('Impossible de modifier le mot de passe.');
            }
            else {
                header('Location: index.php?action=user_profile');
            }
        }
        else {
            throw new Exception('Mauvais identifiant ou mot de passe');
        }
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}
/*
* Manage connect/disconnect and set in $_SESSION 'role', 'pseudo', and 'id'
*/
function connection($pseudo, $password)
{
    $userManager = new Gaetan\P5\Model\UserManager();

    if ($userManager->pseudoExists($pseudo)) {
        $user = $userManager->getUser($pseudo);

        $isPasswordCorrect = password_verify($password, $user->password());

        if ($isPasswordCorrect) {
            $_SESSION['user_id'] = $user->id();
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['role'] = $user->role();
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
            header('Location: ' . $referer);
        }
        else {
            throw new Exception('Mauvais identifiant ou mot de passe');
        }
    }
    else {
        throw new Exception('Mauvais identifiant ou mot de passe');
    }
}

function disconnect()
{
    $_SESSION = array();
    session_destroy();
    header('Location: index.php');
}
/*
* Comment management create/update/delete/report
*/
function addComment($postId, $title, $userId, $content, $userPseudo)
{
    $data = [
    'postId' => $postId,
    'title' => $title,
    'userId' => $userId,
    'content' => $content,
    ];
    $comment = new Gaetan\P5\Model\Comment($data);
    $commentManager = new Gaetan\P5\Model\CommentManager();
    $affectedLines = $commentManager->add($comment);

    if ($affectedLines == false) {
        throw new Exception('Impossible d\'ajouter le commentaire.');
    }
    else {
        //header('Location: index.php?action=post&id=' . $postId);
        $dataToJson = $data;
        $dataToJson['user_pseudo'] = $userPseudo;
        $commentJson = json_encode($dataToJson);
        echo $commentJson;
    }
}

function updatedComment($commentId, $userId, $title, $content)
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($commentManager->exists($commentId))
    {
        $comment = $commentManager->getComment($commentId);
        if ($comment->userId() == $userId) {
            $data = ['id' => $commentId,
                    'title' => $title,
                    'content' => $content];
            $commentUpdated = new Gaetan\P5\Model\Comment($data);
            $affectedLines = $commentManager->update($commentUpdated);
            if ($affectedLines == false) {
                throw new Exception('Impossible de modifier le commentaire.');
            }
            else {
                header('Location: index.php?action=post&id=' . $comment->postId());
            }
        }
        else {
            throw new Exception('Identifiant incorrect.');
        }
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

function deleteComment($userId, $commentId)
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($commentManager->exists($commentId)) {
        $comment = $commentManager->getComment($commentId);
        if ($comment->userId() == $userId) {
            $affectedLines = $commentManager->delete($commentId);
            if ($affectedLines == false) {
                throw new Exception('Il vous est impossible de faire cette action');
            }
            else {
                header('Location: index.php?action=post&id=' . $comment->postId());
            }
        }
        else {
            throw new Exception('Il vous est impossible de faire cette action');
        }
    }
    else {
        throw new Exception('Aucun identifiant de billet envoyé');
    }
}

function report($commentId, $userId)
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($commentManager->exists($commentId))
    {
        $comment = $commentManager->getComment($commentId);
        if ($comment->userId() != $userId) {
            $newReport = $comment->report() + 1 ;
            $data = ['id' => $commentId,
                    'report' => $newReport];
            $commentReported = new Gaetan\P5\Model\Comment($data);
            $affectedLines = $commentManager->report($commentReported);
            if ($affectedLines == false) {
                throw new Exception('Impossible de signaler le commentaire.');
            }
            else {
                header('Location: index.php?action=post&id=' . $comment->postId());
            }
        }
        else {
            throw new Exception('Identifiant incorrect.');
        }
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}
/*
* Actions from the admin pannel
*/
/*
* Posts management create/update/delete
*/
function addPost($userId, $type, $title, $content)
{
    $data = ['userId' => $userId,
            'type' => $type,
            'title' => $title,
            'content' => $content];
    $post = new Gaetan\P5\Model\Post($data);
    $postManager = new Gaetan\P5\Model\PostManager();

    $affectedLines = $postManager->add($post);

    if ($affectedLines == false) {
        throw new Exception('Impossible d\'ajouter le commentaire.');
    }
    else {
        header('Location: index.php?action=listPosts');
    }
}

function updatedPost($id, $type, $title, $content)
{
    $postManager = new Gaetan\P5\Model\PostManager();
    if ($postManager->exists($id))
    {
        $data = ['id' => $id,
                'type' => $type,
                'title' => $title,
                'content' => $content];
        $post = new Gaetan\P5\Model\Post($data);
        $affectedLines = $postManager->update($post);
        if ($affectedLines == false) {
            throw new Exception('Impossible de modifier le billet.');
        }
        else {
            header('Location: index.php');
        }
    }
    else {
        throw new Exception('Identifiant de billet incorrect.');
    }
}

function deletePost($userId, $postId)
{
    $postManager = new Gaetan\P5\Model\PostManager();
    if ($postManager->exists($postId)) {
        $post = $postManager->getPost($postId);
        if ($post->userId() == $userId) {
            $affectedLines = $postManager->delete($postId);
            $commentManager = new Gaetan\P5\Model\CommentManager();
            $commentsDeleted = $commentManager->deletePostComments($postId);
            if ($affectedLines == false OR $commentsDeleted == false) {
                throw new Exception('Il vous est impossible de faire cette action');
            }
            else {
                header('Location: index.php?action=update_list_posts');
            }
        }
        else {
            throw new Exception('Il vous est impossible de faire cette action');
        }
    }
    else {
        throw new Exception('Aucun identifiant de billet envoyé');
    }
}

/*
* Moderation ignore report, delete comment reported
*/
// Moderator, admin
function ignoreComment($commentId)
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($commentManager->exists($commentId))
    {
        $comment = $commentManager->getComment($commentId);
        if ($comment->report() >= 1) {
            $report = 0;
            $data = ['id' => $commentId,
                    'report' => $report];
            $commentReported = new Gaetan\P5\Model\Comment($data);
            $affectedLines = $commentManager->report($commentReported);
            if ($affectedLines == false) {
                throw new Exception('Impossible d\'ignorer le signalement.');
            }
            else {
                header('Location: index.php?action=moderation');
            }
        }
        else {
            throw new Exception('Identifiant incorrect.');
        }
    }
    else {
        throw new Exception('Identifiant incorrect. 2');
    }
}

function deleteReported($commentId)
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($commentManager->exists($commentId)) {
        $comment = $commentManager->getComment($commentId);
        if ($comment->report() == 1) {
            $affectedLines = $commentManager->delete($commentId);
            if ($affectedLines == false) {
                throw new Exception('Il vous est impossible de faire cette action');
            }
            else {
                header('Location: index.php?action=moderation');
            }
        }
        else {
            throw new Exception('Il vous est impossible de faire cette action');
        }
    }
    else {
        throw new Exception('Aucun identifiant de billet envoyé');
    }
}
/*
* User management
*/
// Admin
function updateRole($userId, $role)
{
    $userManager = new Gaetan\P5\Model\UserManager();
    $userId = (int) $userId;
    if ($userManager->exists($userId)) {
        $userToUpdate = $userManager->getUser($userId);
        if ($userToUpdate->role() != 'admin') {
            if ($role == 'editor' OR $role == 'writer' OR $role == 'moderator' OR $role == 'common_user') {
                $data = ['id' => $userId, 'role' => $role];
                $userUpdated = new Gaetan\P5\Model\User($data);
                $affectedLines = $userManager->updateRole($userUpdated);
                if ($affectedLines == false) {
                    throw new Exception('Il vous est impossible de faire cette action');
                }
                else {
                    header('Location: index.php?action=users_list');
                }
            }
            else {
                throw new Exception('Il vous est impossible de faire cette action');
            }
        }
        else {
            throw new Exception('Il vous est impossible de faire cette action');
        }
    }
    else {
        throw new Exception('Il vous est impossible de faire cette action');
    }
}

function deleteUser($userId)
{
    $userManager = new Gaetan\P5\Model\UserManager();
    if ($userManager->exists($userId)) {
        if ($userId != $_SESSION['user_id']) {
            $commentManager = new Gaetan\P5\Model\CommentManager();
            $userToDelete = $userManager->getUser($userId);
            if ($userToDelete->role() != 'admin') {
                $affectedLines = $userManager->delete($userId);
                $commentsDeleted = $commentManager->deleteUserComments($userId);
                if ($affectedLines == false OR $commentsDeleted == false) {
                    throw new Exception('Il vous est impossible de faire cette action');
                }
                else {
                    header('Location: index.php?action=users_list');
                }
            }
            else {
                throw new Exception('Il vous est impossible de faire cette action');
            }
        }
        else {
            throw new Exception('Il vous est impossible de faire cette action');
        }
    }
    else {
        throw new Exception('Il vous est impossible de faire cette action');
    }
}

// Moderator
function deleteCommonUser($userId)
{
    $userManager = new Gaetan\P5\Model\UserManager();
    if ($userManager->exists($userId)) {
        if ($userId != $_SESSION['user_id']) {
            $commentManager = new Gaetan\P5\Model\CommentManager();
            $userToDelete = $userManager->getUser($userId);
            if ($userToDelete->role() == 'common_user') {
                $affectedLines = $userManager->delete($userId);
                $commentsDeleted = $commentManager->deleteUserComments($userId);
                if ($affectedLines == false OR $commentsDeleted == false) {
                    throw new Exception('Il vous est impossible de faire cette action');
                }
                else {
                    header('Location: index.php?action=users_list');
                }
            }
            else {
                throw new Exception('Il vous est impossible de faire cette action');
            }
        }
        else {
            throw new Exception('Il vous est impossible de faire cette action');
        }
    }
    else {
        throw new Exception('Il vous est impossible de faire cette action');
    }
}
