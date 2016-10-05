<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/User.php";
    require_once "src/Item.php";

    $server = 'mysql:host=localhost:8889;dbname=warehouse_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            User::deleteAll();
            Item::deleteAll();
        }

        function test_save()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');

            // Act
            $test_user->save();

            // Assert
            $this->assertEquals([$test_user], User::getAll());
        }

        function test_getAll()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');
            $test_user->save();

            $test_user2 = new User('John', 'test@gmail.com');
            $test_user2->save();

            // Act
            $result = User::getAll();

            // Assert
            $this->assertEquals([$test_user, $test_user2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');
            $test_user->save();

            $test_user2 = new User('John', 'test@gmail.com');
            $test_user2->save();

            // Act
            $result = User::deleteAll();

            // Assert
            $this->assertEquals([], User::getAll());
        }

        function test_find()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');
            $test_user->save();

            $test_user2 = new User('John', 'test@gmail.com');
            $test_user2->save();

            // Act
            $result = User::find($test_user2->getId());

            // Assert
            $this->assertEquals($test_user2, $result);
        }

        function test_delete()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');
            $test_user->save();

            $test_user2 = new User('John', 'test@gmail.com');
            $test_user2->save();

            // Act
            $test_user->delete();

            // Assert
            $this->assertEquals([$test_user2], User::getAll());
        }

        function test_update()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');
            $test_user->save();

            // Act
            $test_user->update('Emily');

            // Assert
            $this->assertEquals('Emily', $test_user->getName());
        }

        function test_getOwnedItems()
        {
            // Arrange
            $test_user = new User('Jane', 'email@gmail.com');
            $test_user->save();

            $owner_id = $test_user->getId();
            $name = "Leaf Blower";
            $image = null;
            $status = "Available";
            $test_item = new Item($owner_id, $name, $image, $status);
            $test_item->save();
            $test_item2 = new Item($owner_id, 'Video Camera', $image, $status);
            $test_item2->save();

            // Act
            $result = $test_user->getOwnedItems();

            // Assert
            $this->assertEquals([$test_item, $test_item2], $result);
        }

        // function test_checkOut()
        // {
        //     // Arrange
        //     $test_user = new User('Jane', 'email@gmail.com');
        //     $test_user->save();
        //
        //     $owner_id = $test_user->getId();
        //     $name = "Leaf Blower";
        //     $image = null;
        //     $status = "Available";
        //     $test_item = new Item($owner_id, $name, $image, $status)
        //     $test_item->save();
        //
        //     // Act
        //     $test_user->checkOut($test_item);
        //
        //     // Assert
        //     $this->assertEquals([$test_item], $test_user->getCheckoutHistory());
        // }

        // function test_getCheckOutHistory()
        // {
        //     // Arrange
        //     $test_user = new User('Jane', 'email@gmail.com');
        //     $test_user->save();
        //
        //     $owner_id = $test_user->getId();
        //     $name = "Leaf Blower";
        //     $image = null;
        //     $status = "Available";
        //     $test_item = new Item($owner_id, $name, $image, $status)
        //     $test_item->save();
        //     $test_user->checkOut($test_item);
        //     $test_item2 = new Item($owner_id, 'Video Camera', $image, $status)
        //     $test_item2->save();
        //     $test_user->checkOut($test_item2);
        //
        //     // Act
        //
        //
        //     // Assert
        //     $this->assertEquals([$test_item], $test_user->getCheckoutHistory());
        // }
    }
 ?>
