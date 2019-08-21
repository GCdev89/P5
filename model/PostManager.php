<?php
namespace Gaetan\P5\Model;

require_once('../model/Manager.php');
require_once('../model/Post.php');

class PostManager extends Manager
{
    /**
    *@var PDO $_db
    */
    private $_db;

    public function __construct()
    {
        $this->setDb();
    }

    public function add(Post $post)
    {
        $q = $this->_db->prepare('INSERT INTO post(user_id, type, title, content, date) VALUES(:user_id, :type, :title, :content, NOW())');
        $affectedLines = $q->execute(array(
            'user_id' => $post->userId(),
            'type' => $post->type(),
            'title' => $post->title(),
            'content' => $post->content()
        ));
        return $affectedLines;
    }

    public function update(Post $post)
    {
        $q = $this->_db->prepare('UPDATE post SET type = :newtype, title = :newtitle, content = :newcontent WHERE id = :id');
        $affectedLines = $q->execute(array(
            'newtype' => $post->type(),
            'newtitle' => $post->title(),
            'newcontent' => $post->content(),
            'id' => $post->id()
        ));
        return $affectedLines;
    }

    public function getPost($postId)
    {
        $q = $this->_db->prepare('SELECT u.pseudo userPseudo, p.id id, p.user_id userId, p.type type, p.title title, p.content content, DATE_FORMAT(p.date, \'%d/%m/%Y à %Hh%imin%ss\') AS date
        FROM user u
        INNER JOIN post p
        ON p.user_id = u.id
        WHERE p.id = :id');
        $q->execute(array('id' => $postId));
        $data = $q->fetch();

        $post = new Post($data);
        $q->closeCursor();

        return $post;
    }

    public function getListPosts($start, $postsByPage, $type, $whereUser)
    {
        $query = 'SELECT u.pseudo userPseudo, p.id id, p.user_id userId, p.type type, p.title title, p.content content, DATE_FORMAT(p.date, \'%d/%m/%Y %Hh%imin\') AS date
        FROM user u
        INNER JOIN post p
            ON p.user_id = u.id
        ';
        $where = '';
        // Filter by user if $whereUser == true
        if ($whereUser > 0) {
            $where = 'WHERE p.user_id = :user_id ';
        }
        // Type filter
        if ($type != NULL) {
            if ($where != '') {
                $where .= ' AND';
            }
            else {
                $where = 'WHERE';
            }
            $where .= ' p.type = :type ';
        }
        $query .= $where;
        $query .= 'ORDER BY p.date DESC
        LIMIT :start, :posts_by_page';

        $q = $this->_db->prepare($query);
        $q->bindValue(':start', $start, $this->_db::PARAM_INT);
        $q->bindValue(':posts_by_page', $postsByPage, $this->_db::PARAM_INT);
        if ($whereUser > 0) {
            $q->bindValue(':user_id', $whereUser, $this->_db::PARAM_STR);
        }
        if ($type != NULL) {
            $q->bindValue(':type', $type, $this->_db::PARAM_STR);
        }

        $q->execute();
        $posts = [];
        while($data = $q->fetch())
        {
            $posts[] = new Post($data);
        }
        $q->closeCursor();

        return $posts;

    }

    public function delete($postId)
    {
        $q = $this->_db->prepare('DELETE FROM post WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $postId));

        return $affectedLines;
    }

    public function count($userId, $type)
    {
        $query = 'SELECT COUNT(id) FROM post';
        $where = '';
        if ($userId > 0) {
            $where = ' WHERE user_id = :user_id';
        }
        if ($type != NULL) {
            if ($where != '') {
                $where .= ' AND';
            }
            else {
                $where = ' WHERE';
            }
            $where .= ' p.type = :type';
        }
        $query .= $where;
        $q= $this->_db->prepare($query);
        if ($userId > 0) {
            $q->bindValue(':user_id', $userId, $this->_db::PARAM_INT);
        }
        if ($type != NULL) {
            $q->bindValue(':type', $type, $this->_db::PARAM_STR);
        }
        $q->execute();
        return $postCount = $q->fetchColumn();
    }

    public function exists($data)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM post WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }

    public function setDb()
    {
        $db = $this->dbConnect();
        $this->_db = $db;
    }
}
