<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Community.php";
    require_once "src/User.php";
    require_once "src/Item.php";

    $server = 'mysql:host=localhost:8889;dbname=warehouse_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CommunityTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
             Community::deleteAll();
             Item::deleteAll();
             User::deleteAll();
        }

        function test_getId()
        {
          // Arrange
          $id = 1;
          $name = "Epicodus";
          $test_community = new Community ($name, $id);
          // Act
          $result = $test_community->getId();
          // assert
          $this->assertEquals($result, $id);
        }

        function test_getName()
        {
          // Arrange
          $name = "Epicodus";
          $test_community = new Community($name);
          // Act
          $result = $test_community->getName();
          // Assert
          $this->assertEquals($name,$result);
        }

      function test_setName()
      {
        // Arrange
        $name = "Epicodus";
        $test_community = new Community($name);
        $new_name = "Flatiron";
        // Act
        $test_community->setName($new_name);
        $result  = $test_community->getName();
        // Assert
        $this->assertEquals($new_name,$result);
      }

      function test_save()
      {
        // Arrange
        $name = "Epicodus";
        $test_community = new Community($name);
        $test_community->save();
        // Act
        $result = Community::getAll();
        // Assert
        $this->assertEquals($test_community,$result[0]);
      }
      //
      function test_getAll()
      {// Arrange
      $name = "Epicodus";
      $test_community = new Community($name);
      $test_community->save();
      $name2 = "Flatiron";
      $test_community2 = new Community ($name2);
      $test_community2->save();
      // Act
      $result = Community::getAll();
      // Assert
      $this->assertEquals([$test_community, $test_community2], $result);
      }
      //
      function test_deleteAll()
      {// Arrange
      $name = "Epicodus";
      $test_community = new Community($name);
      $test_community->save();
      $name2 = "Flatiron";
      $test_community2 = new Community ($name2);
      $test_community2->save();
      // Act
      Community::deleteAll();
      $result = Community::getAll();
      // Assert
      $this->assertEquals([], $result);
      }

      //
      function test_find()
      {// Arrange
      $name = "Epicodus";
      $test_community = new Community($name);
      $test_community->save();
      $name2 = "Flatiron";
      $test_community2 = new Community ($name2);
      $test_community2->save();
      // Act
      $result = Community::find($test_community->getId());
      // Assert
      $this->assertEquals($test_community, $result);
      }
      //
      // function test_getClients()
      // {
      //     //ARRANGE
      //     $name = "Epicodus";
      //     $name2 = "Flatiron";
      //     $test_community = new Community($name);
      //     $test_community->save();
      //     $test_community_id = $test_community->getId();
      //     $test_community2 = new Community($name2);
      //     $test_community2->save();
      //     $test_community_id2 = $test_community2->getId();
      //     $client_name = "Eric";
      //     $test_client = new Client($client_name, $test_community_id);
      //     $test_client->save();
      //     $client_name2 = "Dad";
      //     $test_client2 = new Client($client_name2, $test_community_id);
      //     $test_client2->save();
      //     $client_name3 = "George";
      //     $test_client3 = new Client($client_name3, $test_community_id2);
      //     $test_client3->save();
      //     //ACT
      //     $result = $test_community->getClients();
      //     //ASSERT
      //     $this->assertEquals([$test_client, $test_client2], $result);
      // }
      //
      function test_Update()
      {
          //ARRANGE
          $name = "Epicodus";
          $id = null;
          $test_community = new Community($name, $id);
          $test_community->save();
          $new_name = "Flatiron";
          //ACT
          $test_community->update($new_name);
          //ASSERT
          $this->assertEquals("Flatiron", $test_community->getName());
      }
      //
      function testDelete()
      {
          //Arrange
          $name = "Epicodus";
          $id = null;
          $test_community = new Community($name, $id);
          $test_community->save();
          $name2 = "Flatiron";
          $test_community2 = new Community($name2, $id);
          $test_community2->save();
          //Act
          $test_community->delete();
          //Assert
          $this->assertEquals([$test_community2], Community::getAll());
      }

      // function testDeleteCommunityClients()
      // {
      //     //Arrange
      //     $name = "Epicodus";
      //     $id = null;
      //     $test_community = new Community($name, $id);
      //     $test_community->save();
      //     $client = "Tanya";
      //     $community_id = $test_community->getId();
      //     $test_client = new Client($client, $id, $community_id);
      //     $test_client->save();
      //     //Act
      //     $test_community->delete();
      //     //Assert
      //     $this->assertEquals([], Client::getAll());
      // }
     }
?>
