<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/User.php";

    $server = 'mysql:host=localhost:3307;dbname=warehouse_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            User::deleteAll();
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
            $this->assertEquals([], User::getALl());
        }
    }
 ?>
