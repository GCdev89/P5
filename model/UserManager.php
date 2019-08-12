<?php
namespace Gaetan\P5\Model;

require_once('../model/Manager.php');
require('../model/User.php');

class UserManager extends Manager
{
    /**
    *@var PDO $_db
    */
    private $_db;

    public function __construct()
    {
        $this->setDb();
    }

    public function add(User $user)
    {
        $q = $this->_db->prepare('INSERT INTO user(role, pseudo, password, mail, date) VALUES(:role, :pseudo, :password, :mail, NOW())');
        $affectedLines= $q->execute(array(
            'role' => $user->role(),
            'pseudo' => $user->pseudo(),
            'mail' => $user->mail(),
            'password' => $user->password()
        ));
        return $affectedLines;
    }

    public function getUser($info)
    {
        if (is_int($info))
        {
            $q = $this->_db->prepare('SELECT id, role, pseudo, password, mail, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin\') AS date FROM user WHERE id = :id');
            $q->execute(array('id' => $info));
            $data = $q->fetch();

            $user = new User($data);
            $q->closeCursor();

            return $user;
        }
        else {
            $q = $this->_db->prepare('SELECT id, role, pseudo, password, mail, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM user WHERE pseudo = :pseudo');
            $q->execute(array('pseudo' => $info));
            $data = $q->fetch();

            $user = new User($data);
            $q->closeCursor();

            return $user;
        }

    }

    public function getListUsers($start, $usersByPage)
    {
        $users = [];

        $q = $this->_db->query('SELECT id, role, pseudo, mail, DATE_FORMAT(date, \'%d/%m/%Y à %Hh%imin%ss\') AS date FROM user ORDER BY pseudo ASC LIMIT '. $start . ', ' . $usersByPage);

        while($data = $q->fetch())
        {
            $users[] = new User($data);
        }
        $q->closeCursor();

        return $users;
    }

    public function updateMail(User $user)
    {
        $q = $this->_db->prepare('UPDATE user SET mail = :mail WHERE id = :id');
        $affectedLines = $q->execute(array(
            'mail' => $user->mail(),
            'id' => $user->id()
        ));
        return $affectedLines;
    }

    public function updatePassword(User $user)
    {
        $q = $this->_db->prepare('UPDATE user SET password = :password WHERE id = :id');
        $affectedLines = $q->execute(array(
            'password' => $user->password(),
            'id' => $user->id()
        ));
        return $affectedLines;
    }

    public function delete($userId)
    {
        $q = $this->_db->prepare('DELETE FROM user WHERE id = :id');
        $affectedLines = $q->execute(array('id' => $userId));

        return $affectedLines;
    }

    public function count()
    {
        $q = $this->_db->query('SELECT COUNT(id) FROM user');
        return $usersCount = $q->fetchColumn();
    }

    public function exists($data)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM user WHERE id = :id');
        $q->execute(array('id' => $data));
        return (bool) $q->fetchColumn();
    }

    public function pseudoExists($data)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM user WHERE pseudo = :pseudo');
        $q->execute(array('pseudo' => $data));
        return (bool) $q->fetchColumn();
    }

    public function mailExists($data)
    {
        $q = $this->_db->prepare('SELECT COUNT(*) FROM user WHERE mail = :mail');
        $q->execute(array('mail' => $data));
        return (bool) $q->fetchColumn();
    }

    public function setDb()
    {
        $db = $this->dbConnect();
        $this->_db = $db;
    }
}
