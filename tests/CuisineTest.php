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
            $result = $cuisine::getAll();

            //assert
            $this->assertEquals($cuisine, $result[0]);

        }
    }

 ?>
