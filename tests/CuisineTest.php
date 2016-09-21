<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";
    require_once "src/Restaurant.php";

    $server = 'mysql:host=localhost;dbname=best_restaurants_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Cuisine::deleteAll();
          Restaurant::deleteAll();
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

        function test_getRestaurants()
        {
            //arrange
            $id = 15;
            $type = "Italian";
            $cuisine = new Cuisine($id, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();

            $name = "TALKO Taco";
            $rate = 4;
            $restaurant = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant->save();

            $name = "Pizzeria";
            $rate = 4;
            $restaurant_two = new Restaurant($id, $cuisine_id, $name, $rate);
            $restaurant_two->save();

            //act
            $result = $cuisine->getRestaurants();

            //assert
            $this->assertEquals([$restaurant, $restaurant_two], $result);

        }

        function test_update()
        {
            //arrange
            $type = "Italian";
            $cuisine = new Cuisine($id=null, $type);
            $cuisine->save();

            $new_type = "Fusion";

            //act
            $cuisine->update($new_type);

            //assert
            $this->assertEquals($new_type, $cuisine->getType());

        }

        function test_delete()
        {
            //arrange
            $type = "Italian";
            $cuisine = new Cuisine($id=null, $type);
            $cuisine->save();

            $new_type = "Fusion";
            $cuisine2 = new Cuisine($id=null, $type);
            $cuisine2->save();

            //act
            $cuisine->delete();

            //assert
            $this->assertEquals([$cuisine2], Cuisine::getAll());

        }

        function test_delete_cuisine_retaurants()
        {
            //arrange
            $type = "Italian";
            $cuisine = new Cuisine($id=null, $type);
            $cuisine->save();

            $cuisine_id = $cuisine->getId();
            $name = "Pizzeria";
            $rate= 4;
            $restaurant = new Restaurant ($id=null, $cuisine_id, $name, $rate);
            $restaurant->save();

            //act
            $cuisine->delete();

            //assert
            $this->assertEquals([], Restaurant::getAll());

        }
    }

 ?>
