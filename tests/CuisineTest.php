<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Cuisine::deleteAll();
        }

        function test_getId()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);

            //act
            $result = $cuisine->getId();

            //assert
            $this->assertEquals($id, $result);

        }

        function test_getType()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);

            //act
            $result = $cuisine->getType();

            //assert
            $this->assertEquals($type, $result);

        }

        function test_save()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            //act
            $result = $cuisine->getAll();

            //assert
            $this->assertEquals($cuisine, $result[0]);

        }

        function test_getAll()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $id = 15;
            $type = "Italian";
            $cuisine_two = new Cuisine($id, $type);
            $cuisine_two->save();

            //act
            $result = Cuisine::getAll();

            //assert
            $this->assertEquals([$cuisine, $cuisine_two], $result);

        }

        function test_deleteAll()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $id = 15;
            $type = "Italian";
            $cuisine_two = new Cuisine($id, $type);
            $cuisine_two->save();

            //act
            $result = Cuisine::deleteAll();

            //assert
            $result = Cuisine::getAll();
            $this->assertEquals([], $result);

        }

        function test_find()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $id = 15;
            $type = "Italian";
            $cuisine_two = new Cuisine($id, $type);
            $cuisine_two->save();

            //act
            $result = Cuisine::find($cuisine->getId());

            //assert
            $this->assertEquals($cuisine, $result);

        }
    }

 ?>
