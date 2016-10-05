<?php

  class Community
  {
    private $name;
    private $id;

    function __construct($community_name, $id = null)
    {
      $this->name = $community_name;
      $this->id = $id;
    }

    function getId()
    {
      return $this->id;
    }

    function setName($community_name)
    {
      $this->name = $community_name;
    }

    function getName()
    {
      return $this->name;
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO communities (name) VALUES ('{$this->getName()}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function getUsers()
    {
      $users = array();
      $returned_users = $GLOBALS['DB']->query("SELECT * FROM users WHERE community_id = {$this->getID()};");

      foreach ($returned_users as $user)
      {
        $user_name = $user['name'];
        $id = $user['id'];
        $community_id = $user['barber_id'];
        $new_user = new Client($user_name, $community_id, $id);
        array_push($users, $new_user);
      }
        return $users;
      }

      function update($community_name)
      {
        $GLOBALS['DB']->exec("UPDATE communities SET name = '{$community_name}' WHERE id = {$this->getId()}");
        $this->setName($community_name);
      }

      static function getAll()
      {
        $returned_community = $GLOBALS["DB"]->query("SELECT * FROM communities;");
        $communities = array();
        foreach ($returned_community as $community)
        {
            $name = $community['name'];
            $community_id = $community['id'];
            $new_community = new Community($name, $community_id);
            array_push($communities, $new_community);
        }

        return $communities;
      }

      function delete()
      {
        $GLOBALS['DB']->exec("DELETE FROM communities WHERE id = {$this->getId()};");
        $GLOBALS['DB']->exec("DELETE FROM users WHERE community_id = {$this->getId()};");
      }

      static function deleteAll()
      {
          $GLOBALS['DB']->exec("DELETE from communities;");
      }

      static function find($search_id)
        {
            $found_community = null;
            $communities = Community::getAll();
            foreach($communities as $community)
            {
                $community_id = $community->getId();
                if ($community_id == $search_id)
                {
                    $found_community = $community;
                }
            }
            return $found_community;
        }
    }
?>
