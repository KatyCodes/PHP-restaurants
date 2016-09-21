<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Restaurant::deleteAll();
            Cuisine::deleteAll();
        }

        function test_getId()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);

            //act
            $result = $restaurant->getId();

            //assert
            $this->assertEquals(true, is_numeric($result));

        }

        function test_getCuisineId()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);

            //act
            $result = $restaurant->getCuisineId();

            //assert
            $this->assertEquals(true, is_numeric($result));

        }

        function test_getName()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);

            //act
            $result = $restaurant->getName();

            //assert
            $this->assertEquals($name, $result);

        }

        function test_getRate()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);

            //act
            $result = $restaurant->getRate();

            //assert
            $this->assertEquals($rate, $result);

        }

        function test_save()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant->save();

            //act
            $result = $restaurant->getAll();

            //assert
            $this->assertEquals($restaurant, $result[0]);

        }

        function test_getAll()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant->save();

            $id = 2;
            $cuisine_id = 1;
            $name = "Pizzeria";
            $rate = 4;
            $restaurant_two = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant_two->save();

            //act
            $result = Restaurant::getAll();

            //assert
            $this->assertEquals([$restaurant, $restaurant_two], $result);

        }

        function test_deleteAll()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant->save();

            $id = 2;
            $cuisine_id = 1;
            $name = "Pizzeria";
            $rate = 4;
            $restaurant_two = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant_two->save();

            //act
            $result = Restaurant::deleteAll();

            //assert
            $result = Restaurant::getAll();
            $this->assertEquals([], $result);

        }

        function test_find()
        {
            //arrange
            $id = 1;
            $type = "Mexican Food";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant->save();

            $id = 2;
            $cuisine_id = 1;
            $name = "Pizzeria";
            $rate = 4;
            $restaurant_two = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant_two->save();

            //act
            $result = Restaurant::find($restaurant->getId());

            //assert
            $this->assertEquals($restaurant, $result);

        }

    }

 ?>
