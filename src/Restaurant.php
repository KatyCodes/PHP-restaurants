<?php
    class Restaurant
    {
        private $id;
        private $cuisine_id;
        private $name;
        private $rate;

        function __construct($id, $cuisine_id, $name, $rate)
        {
            $this->id = $id;
            $this->cuisine_id = $cuisine_id;
            $this->name = $name;
            $this->rate = $rate;
        }

        function getId()
        {
            return $this->id;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function setName($name)
        {
            $this->name = (string) $name;
        }

        function getName()
        {
            return $this->name;
        }

        function setRate($rate)
        {
            $this->rate = (int) $rate;
        }

        function getRate()
        {
            return $this->rate;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (cuisine_id, name, rate) VALUES ({$this->getCuisineId()}, '{$this->getName()}', {$this->getRate()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name, $new_rate)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("UPDATE restaurants SET rate = '{$new_rate}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setRate($new_rate);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
            $restaurants = array();

            foreach($returned_restaurants as $restaurant){
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $name = $restaurant['name'];
                $rate = $restaurant['rate'];
                $new_restaurant = New Restaurant($id, $cuisine_id, $name, $rate);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        static function find($search_id)
        {
            $found_restaurant = null;
            $restaurants = Restaurant::getAll();
            foreach($restaurants as $restaurant){
                $restaurant_id = $restaurant->getId();
                if($restaurant_id == $search_id){
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }
    }

?>
