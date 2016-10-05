<?php
    class Item
    {
        private $owner_id;
        private $name;
        private $image;
        private $status;
        private $id;

        function __construct($owner_id, $name, $image, $status, $id=null)
        {
            $this->owner_id = $owner_id;
            $this->name = $name;
            $this->image = $image;
            $this->status = $status;
            $this->id = $id;
        }

        function getOwnerId()
        {
            return $this->owner_id;
        }
        function setOwnerId($new_owner_id)
        {
            $this->owner_id = $new_owner_id;
        }
        function getName()
        {
            return $this->name;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function getImage()
        {
            return $this->image;
        }
        function setImage($new_image)
        {
            $this->image = $new_image;
        }
        function getStatus()
        {
            return $this->status;
        }
        function setStatus($new_status)
        {
            $this->status = $new_status;
        }
        function getId()
        {
            return $this->id;
        }


        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO items (name, status, image, owner_id) VALUES ('{$this->getName()}', {$this->getStatus()}, '{$this->getImage()}', {$this->getOwnerId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_items = $GLOBALS['DB']->query("SELECT * FROM items;");
            $all_items = array();
            foreach ($returned_items as $item)
            {
                $owner_id = $item['owner_id'];
                $name = $item['name'];
                $image = $item['image'];
                $status = $item['status'];
                $id = $item['id'];
                $test_item = new Item($owner_id, $name, $image, $status, $id);
                array_push($all_items, $test_item);
            }
            return $all_items;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM items;");
        }

        static function find($search_id)
        {
            $found_item = null;
            $items = Item::getAll();
            foreach ($items as $item) {
                $item_id = $item->getId();
                if ($item_id == $search_id) {
                    $found_item = $item;
                }
            }
            return $found_item;
        }

        function updateName($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE items SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function updateStatus($new_status)
        {
            $GLOBALS['DB']->exec("UPDATE items SET status = {$new_status} WHERE id = {$this->getId()};");
            $this->setStatus($new_status);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM items WHERE id = {$this->getId()};");
        }


    }


 ?>
