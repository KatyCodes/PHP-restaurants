<?php
    class Cuisine
    {
        private $id;
        private $type;

        function __construct($id= null, $type)
        {
            $this->id = $id;
            $this->type = $type;
        }

        function getId()
        {
            return $this->id;
        }

        function setType($type)
        {
            $this->type = (string) $type;
        }

        function getType()
        {
            return $this->type;
        }

        function getRestaurants()
        {
            $restaurants = array();
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
            foreach($returned_restaurants as $restaurant){
                $id = $restaurant['id'];
                $cuisine_id = $restaurant['cuisine_id'];
                $name = $restaurant['name'];
                $rate = $restaurant['rate'];
                $new_restaurant = new Restaurant($id, $cuisine_id, $name, $rate);
                array_push($restaurants, $new_restaurant);
            }
            return $restaurants;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cuisines (type) VALUES ('{$this->getType()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_type)
        {
            $GLOBALS['DB']->exec("UPDATE cuisines SET type = '{$new_type}' WHERE id = {$this->getId()};");
            $this->setType($new_type);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE cuisine_id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $cuisines = array();
            foreach($returned_cuisines as $cuisine){
                $id = $cuisine['id'];
                $type = $cuisine['type'];
                $new_cuisine = new Cuisine($id, $type);
                array_push($cuisines, $new_cuisine);
            }
            return $cuisines;
        }

        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine){
                $cuisine_id = $cuisine->getId();
                if ($cuisine_id == $search_id){
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");

        }
    }

?>
