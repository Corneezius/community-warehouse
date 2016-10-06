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

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM users WHERE id = {$this->getId()};");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE users SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function getOwnedItems()
        {
            $got_items = $GLOBALS['DB']->query("SELECT * FROM items WHERE owner_id = {$this->getId()};");
            $items = [];
            foreach ($got_items as $item)
            {
                $owner_id = $item['owner_id'];
                $name = $item['name'];
                $image = $item['image'];
                $status = $item['status'];
                $id = $item['id'];
                $new_item = new Item($owner_id, $name, $image, $status, $id);
                array_push($items, $new_item);
            }
            return $items;
        }

        function checkOut($item)
        {
            $GLOBALS['DB']->exec("INSERT INTO checkouts (item_id, user_id) VALUES ({$item->getId()}, {$this->getId()});");
        }

        function getCheckoutHistory()
        {
            $rented_items = $GLOBALS['DB']->query("SELECT items.* FROM users
                INNER JOIN checkouts ON (users.id = checkouts.user_id)
                JOIN items ON (checkouts.item_id = items.id)
                WHERE checkouts.user_id = {$this->getId()};");
            $rented_items = $rented_items->fetchAll(PDO::FETCH_ASSOC);
            $items = array();
            foreach($rented_items as $item)
            {
                $owner_id = $item['owner_id'];
                $name = $item['name'];
                $image = $item['image'];
                $status = $item['status'];
                $id = $item['id'];
                $new_item = new Item($owner_id, $name, $image, $status, $id);
                array_push($items, $new_item);
            }
            return $items;
        }

        // function getCheckoutHistory()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT item_id FROM checkouts WHERE user_id = {$this->getId()};");
        //     $item_ids = $query->fetchAll(PDO::FETCH_ASSOC);
        //
        //     $items = [];
        //     foreach($item_ids as $id)
        //     {
        //         $item_id = $id['item_id'];
        //         $result = $GLOBALS['DB']->query("SELECT * FROM items WHERE id = {$item_id};");
        //         $returned_item = $result->fetchAll(PDO::FETCH_ASSOC);
        //
        //         $owner_id = $returned_item[0]['owner_id'];
        //         $name = $returned_item[0]['name'];
        //         $image = $returned_item[0]['image'];
        //         $status = $returned_item[0]['status'];
        //         $ID = $returned_item[0]['id'];
        //         $new_item = new Item($owner_id, $name, $image, $status, $ID);
        //         array_push($items, $new_item);
        //     }
        //     return $items;
        // }

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
            $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE user_id = {$this->getId()};");

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
