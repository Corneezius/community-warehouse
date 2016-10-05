<?php

    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Item.php";
    require_once "src/User.php";

    $server = 'mysql:host=localhost:8889;dbname=warehouse_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class ItemTest extends PHPUnit_Framework_TestCase {

        protected function tearDown()
        {
            Item::deleteAll();
            User::deleteAll();
        }
        function testSave()
        {
            //ARRANGE
            $owner_id = null;
            $name = "3D Printer";
            $image = null;
            $status = true;
            $test_item = new Item($owner_id, $name, $image, $status);

            //ACT
            $test_item->save();

            //ASSERT
            $this->assertEquals([$test_item], Item::getAll());
        }
        function testGetAll()
        {
            //ARRANGE
            $owner_id = null;
            $name = "3D Printer";
            $image = null;
            $status = true;
            $test_item = new Item($owner_id, $name, $image, $status);
            $test_item->save();

            $name2 = "Power washer";
            $test_item2 = new Item($owner_id, $name2, $image, $status);
            $test_item2->save();

            //ACT
            $result = Item::getAll();

            //ASSERT
            $this->assertEquals([$test_item, $test_item2], $result);
        }
        function testDeleteAll()
        {
            //ARRANGE
            $owner_id = null;
            $name = "3D Printer";
            $image = null;
            $status = true;
            $test_item = new Item($owner_id, $name, $image, $status);
            $test_item->save();

            $name2 = "Power washer";
            $test_item2 = new Item($owner_id, $name2, $image, $status);
            $test_item2->save();

            //ACT
            Item::deleteAll();

            //ASSERT
            $this->assertEquals([], Item::getAll());
        }

        function testFind()
       {
           //ARRANGE
           $owner_id = null;
           $name = "3D Printer";
           $image = null;
           $status = true;
           $test_item = new Item($owner_id, $name, $image, $status);
           $test_item->save();

           $name2 = "Power washer";
           $test_item2 = new Item($owner_id, $name2, $image, $status);
           $test_item2->save();

           //ACT
           $result = Item::find($test_item2->getId());

           //ASSERT
           $this->assertEquals($test_item2, $result);
       }
       function testUpdateName()
       {
           //ARRANGE
           $owner_id = null;
           $name = "3D Printer";
           $image = null;
           $status = true;
           $test_item = new Item($owner_id, $name, $image, $status);
           $test_item->save();

           $new_name = "Laser Printer";

           //ACT
           $test_item->updateName($new_name);

           //ASSERT
           $this->assertEquals("Laser Printer", $test_item->getName());
       }

       function testUpdateStatus()
       {
           //ARRANGE
           $owner_id = null;
           $name = "3D Printer";
           $image = null;
           $status = true;
           $test_item = new Item($owner_id, $name, $image, $status);
           $test_item->save();

           $new_status = false;

           //ACT
           $test_item->updateStatus($new_status);

           //ASSERT
           $this->assertEquals(false, $test_item->getStatus());
       }

       function testDelete()
        {
            //ARRANGE
            $owner_id = null;
            $name = "3D Printer";
            $image = null;
            $status = true;
            $test_item = new Item($owner_id, $name, $image, $status);
            $test_item->save();

            $name2 = "Power washer";
            $test_item2 = new Item($owner_id, $name2, $image, $status);
            $test_item2->save();

            //ACT
            $test_item->delete();

            //ASSERT
            $this->assertEquals([$test_item2], Item::getAll());
        }


    }


 ?>
