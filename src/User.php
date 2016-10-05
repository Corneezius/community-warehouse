<?php
    class User
    {
        private $id;
        private $name;
        private $email;

        function __construct($name, $email, $id=null)
        {
            $this->name = $name;
            $this->email = $email;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getEmail()
        {
            return $this->email;
        }

        function setEmail($new_email)
        {
            $this->name = (string) $new_email;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO users (name, email) VALUES ('{$this->getName()}', '{$this->getEmail()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $got_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            $users = [];
            foreach($got_users as $user)
            {
                $new_user = new User($user['name'], $user['email'], $user['id']);
                array_push($users, $new_user);
            }
            return $users;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM users;");
        }

        static function find($search_id)
        {
            $found_user = null;
            $users = User::getAll();
            foreach($users as $user)
            {
                if ($user->getId() == $search_id)
                {
                    $found_user = $user;
                }
            }
            return $found_user;
        }
    }
 ?>
