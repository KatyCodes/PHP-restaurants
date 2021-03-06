<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();
    $app = new Silex\Application();
    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=best_restaurants';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    //for CRUD functionality
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('cuisines' =>  Cuisine::getAll()));
    });

    $app->post("/addCuisine", function() use ($app) {
        $cuisine = new Cuisine($id= null, $_POST['cuisine']);
        $cuisine->save();
        return $app['twig']->render('index.html.twig', array('cuisines' =>  Cuisine::getAll()));
    });

    $app->post("/deleteCuisines", function() use ($app) {
        Cuisine::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines' =>  Cuisine::getAll()));
    });

    //from index to cuisine page showing all restaurants for that cuisine
    $app->get("/getCuisine/{id}", function($id) use ($app){
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    //Routes to update cuisine name
    $app->get("/updateCuisine/{id}", function($id) use($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.html.twig', array('cuisine' => $cuisine));
    });

    //after updating will lead back to that cuisine page
    $app->patch("/updatedCuisine/{id}", function($id) use ($app){
        $type = $_POST['type'];
        $cuisine = Cuisine::find($id);
        $cuisine->update($type);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->delete("/deleteCuisine/{id}", function($id) use ($app){
        $cuisine = Cuisine::find($id);
        $cuisine->delete();
        return $app['twig']->render('cuisine_deleted.html.twig', array('cuisine' => $cuisine));
    });

    //////////to search restraunts in a cuisine
    $app->post("/searchCuisines{id}", function($id) use ($app) {
        $cuisine_id = $id;
        $cuisine = Cuisine::find($id);
        // $restaurant= Restaurant::find($id);
        $search = $_POST['search'];
        $results = Restaurant::search($cuisine_id, $search);
        return $app['twig']->render('search_results.html.twig', array('results' => $results, 'cuisine' => $cuisine));
    });

    //leads to individual restaurant info page
    $app->get("/getRestaurant/{id}", function($id) use ($app){
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });


    $app->get("/confirmDeleteRestaurant/{id}", function($id) use ($app){
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    $app->post("/addRestaurant", function() use ($app) {
        $name = $_POST['name'];
        $rate = $_POST['rate'];
        $cuisine_id = $_POST['cuisine_id'];
        $restaurant= new Restaurant($id= null, $cuisine_id, $name, $rate);
        $restaurant->save();
        $cuisine = Cuisine::find($cuisine_id);
        return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
    });

    //after changing restaurant name and rate
    $app->patch("/updatedRestaurant/{id}", function ($id) use ($app){
        $name = $_POST['name'];
        $rate = $_POST['rate'];
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $restaurant->update($name, $rate);
        return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    //to delete an individual restaurant
    $app->delete("/deleteRestaurant/{id}", function($id) use ($app){
        $restaurant = Restaurant::find($id);
        $cuisine = Cuisine::find($restaurant->getCuisineId());
        $restaurant->delete();
        return $app['twig']->render('restaurant_deleted.html.twig', array('restaurant' => $restaurant, 'cuisine' => $cuisine));
    });

    //to delete all restaurants in a cuisine
    $app->post("/deleteRestaurants", function() use ($app) {
        Restaurant::deleteAll();
        return $app['twig']->render('index.html.twig', array('cuisines' =>  Cuisine::getAll()));
    });

    return $app;
?>
