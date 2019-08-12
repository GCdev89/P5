<?php
namespace Gaetan\P5\Model;

class Post
{
    /**
    *@var int $_id
    *@var string $_user_id
    *@var string $_user_pseudo
    *@var string $_type Define the type of posts, either chapter, announcement or general
    *@var string $_title
    *@var string $_content
    *@var int $_date
    */

    private $_id;
    private $_user_id;
    private $_user_pseudo;
    private $_type;
    private $_title;
    private $_content;
    private $_date;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters

    public function id()
    {
        return $this->_id;
    }

    public function userId()
    {
        return $this->_user_id;
    }

    public function userPseudo()
    {
        return $this->_user_pseudo;
    }

    public function type()
    {
        return $this->_type;
    }

    public function title()
    {
        return $this->_title;
    }

    public function content()
    {
        return $this->_content;
    }

    public function date()
    {
        return $this->_date;
    }

    // Setters

    public function setId($id)
    {
        $id = (int) $id;
        if ($id > 0) {
            $this->_id = $id;
        }
    }

    public function setUserId($userId)
    {
        $userId = (int) $userId;
        if ($userId > 0) {
            $this->_user_id = $userId;
        }
    }

    public function setUserPseudo($userPseudo)
    {
        if(is_string($userPseudo))
        {
            $this->_user_pseudo = $userPseudo;
        }
    }

    public function setType($type)
    {
        if(is_string($type))
        {
            if ($type == 'chapter' OR $type == 'announcement' OR $type == 'general') {
                $this->_type = $type;
            }
        }
    }

    public function setTitle($title)
    {
        if(is_string($title))
        {
            $this->_title = $title;
        }
    }

    public function setContent($content)
    {
        if(is_string($content))
        {
            $this->_content = $content;
        }
    }

    public function setDate($date)
    {
        if(is_string($date))
        {
            $this->_date = $date;
        }
    }
}
