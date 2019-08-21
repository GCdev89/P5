<?php
/*
* Manage views that must be returned to the user, reading the DB
*/
require_once('../model/PostManager.php');
require_once('../model/CommentManager.php');
require_once('../model/UserManager.php');

/*
* Set frontoffice view if conditions are correct
*/
function listPosts($type)
{
    $postManager = new Gaetan\P5\Model\PostManager();
    $userId = 0; // Allow to count every posts
    $postCount = $postManager->count($userId, $type);
    $postsByPage = 3;
    $countPages = ceil($postCount / $postsByPage);
    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $postsByPage;
    $whereUser = 0;
    $posts = $postManager->getListPosts($start, $postsByPage, $type, $whereUser);
    $action = 'list_posts';
    if ($type != NULL) {
        $isActive = $type;
        require('../view/paginationByType.php');
    }
    else {
        $isActive = 'home';
        require('../view/pagination.php');
    }
    require('../view/frontoffice/listPostsView.php');
}

function post($postId)
{
    $postManager = new Gaetan\P5\Model\PostManager();
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($postManager->exists($postId)) {
        $post = $postManager->getPost($postId);

        $commentsCount = $commentManager->count($postId);
        $commentsByPage = 10;
        $countPages = ceil($commentsCount / $commentsByPage);
        if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
            $currentPage = intval($_GET['page']);
        }
        else {
            $currentPage = 1;
        }
        $start = ($currentPage - 1) * $commentsByPage;

        $comments = $commentManager->getListComments($postId, $start, $commentsByPage);
        $action = 'post&amp;id=' . $postId;

        require('../view/pagination.php');
        require('../view/frontoffice/postView.php');
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

function registration()
{
    require('../view/frontoffice/registrationView.php');
}

function registered()
{
    require('../view/frontoffice/registeredView.php');

}

function updateComment($commentId, $userId)
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    if ($commentManager->exists($commentId))
    {
        $comment = $commentManager->getComment($commentId);
        if ($comment->userId() == $userId) {
            require('../view/frontoffice/updateCommentView.php');
        }
        else {
            throw new Exception('Identifiant incorrect.');
        }
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

function userProfile($userId)
{
    $userManager = new Gaetan\P5\Model\UserManager();
    if ($userManager->exists($userId)) {
        $user = $userManager->getUser($userId);
        require('../view/frontoffice/userProfileView.php');
    }
    else {
        throw new Exception('Identifiant incorrect.');
    }
}

/*
* Set backoffice view if conditions are verified
*/
// For writer, editor and admin
function newPost()
{
    $isActive = 'newPost';
    require('../view/backoffice/newPostView.php');
}

function updatePost($postId)
{
    $postManager = new Gaetan\P5\Model\PostManager();
    if ($postManager->exists($postId))
    {
        if ($_SESSION['role'] == 'writer') {
            $post = $postManager->getPost($postId);
            if ($post->userId() == $_SESSION['user_id']) {
                require('../view/backoffice/updatePostView.php');
            }
            else {
                throw new Exception('Identifiant incorrect.');
            }
        }
        else {
            $post = $postManager->getPost($postId);
            require('../view/backoffice/updatePostView.php');
        }
    }
    else {
        throw new Exception('Identifiant de billet incorrect.');
    }
}

// For editor and admin
function updateListPosts($allPosts, $type)
{
    // Test condition, either return all posts, or just those specific to one user
    if ($allPosts == false) {
        $userId = Session::getUserId();
        $whereUser = $userId;
        $isActive = 'myPosts';
        $action = 'update_list_my_posts';
    }
    else {
        $userId = 0;
        $whereUser = 0;
        $isActive = 'update_list_posts';
        $action = 'update_list_posts';
    }
    $postManager = new Gaetan\P5\Model\PostManager();
    $postCount = $postManager->count($userId, $type);
    $postsByPage = 3;
    $countPages = ceil($postCount / $postsByPage);
    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $postsByPage;
    $posts = $postManager->getListPosts($start, $postsByPage, $type, $whereUser);
    if ($type != NULL) {
        $isTypeActive = $type;
        require('../view/paginationByType.php');
    }
    else {
        $isTypeActive = 'all';
        require('../view/pagination.php');
    }
    require('../view/backoffice/updateListPostsView.php');
}

// For moderator and admin
function moderation()
{
    $commentManager = new Gaetan\P5\Model\CommentManager();
    $reportCount = $commentManager->countReport();
    $reportsByPage = 10;
    $countPages = ceil($reportCount / $reportsByPage);

    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $reportsByPage;

    $comments = $commentManager->getReportedList($start, $reportsByPage);
    $action = 'moderation';
    $isActive = 'moderation';

    require('../view/pagination.php');
    require('../view/backoffice/moderationView.php');
}

function usersList()
{
    $userManager = new Gaetan\P5\Model\UserManager();
    $usersCount =$userManager->count();
    $usersByPage = 20;
    $countPages = ceil($usersCount / $usersByPage);

    if (isset($_GET['page']) && $_GET['page'] > 0 && $_GET['page'] <= $countPages) {
        $currentPage = intval($_GET['page']);
    }
    else {
        $currentPage = 1;
    }
    $start = ($currentPage - 1) * $usersByPage;
    $users = $userManager->getListUsers($start, $usersByPage);

    $action = 'users_list';
    $isActive = 'users';

    require('../view/pagination.php');
    if ($_SESSION['role'] == 'admin') {
        require('../view/backoffice/listUsersAdminView.php');
    }
    else {
        require('../view/backoffice/listUsersView.php');
    }
}
