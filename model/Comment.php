<?php
namespace Gaetan\P5\Model;

class Comment
{
    /**
    *@var int $_id
    *@var int $_user_id
    *@var int $_post_id
    *@var string $_user_pseudo
    *@var string $_title
    *@var string $_content
    *@var int $_report If $_report == 1, the comment is reported
    *@var int $_date
    */

    private $_id;
    private $_user_id;
    private $_post_id;
    private $_user_pseudo;
    private $_title;
    private $_content;
    private $_report;
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

    public function postId()
    {
        return $this->_post_id;
    }

    public function userPseudo()
    {
        return $this->_user_pseudo;
    }

    public function title()
    {
        return $this->_title;
    }

    public function content()
    {
        return $this->_content;
    }

    public function report()
    {
        return $this->_report;
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

    public function setPostId($postId)
    {
        $postId = (int) $postId;
        if ($postId > 0) {
            $this->_post_id = $postId;
        }
    }

    public function setUserPseudo($userPseudo)
    {
        if(is_string($userPseudo))
        {
            $this->_user_pseudo = $userPseudo;
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

    public function setReport($report)
    {
        $report = (int) $report;
        if ($report >= 0) {
            $this->_report = $report;
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
