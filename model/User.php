<?php
namespace Gaetan\P5\Model;

class User
{
    /**
    *@var int $_id
    *@var string $_role Define the user's role. Either common_user or admin
    *@var string $_pseudo
    *@var string $_password
    *@var string $_mail
    *@var $_date_creation
    */


    private $_id;
    private $_role;
    private $_pseudo;
    private $_password;
    private $_mail;
    private $_date_creation;

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

    public function role()
    {
        return $this->_role;
    }

    public function pseudo()
    {
        return $this->_pseudo;
    }

    public function password()
    {
        return $this->_password;
    }

    public function mail()
    {
        return $this->_mail;
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

    public function setRole($role)
    {
        if(is_string($role))
        {
            $this->_role = $role;
        }
    }

    public function setPseudo($pseudo)
    {
        if(is_string($pseudo))
        {
            $this->_pseudo = $pseudo;
        }
    }

    public function setPassword($password)
    {
        if(is_string($password))
        {
            $this->_password = $password;
        }
    }

    public function setMail($mail)
    {
        if(is_string($mail))
        {
            $this->_mail = $mail;
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
