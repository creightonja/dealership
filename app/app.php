<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/car.php";

  session_id("session1");  //Creating cookie for session
    if (empty($_SESSION['list_of_cars'])) {
      $_SESSION['list_of_cars'] = array();
    }

  session_id("session2");
    if (empty($_SESSION['added_cars'])) {
      $_SESSION['added_cars'] = array();
    }

  $app = new Silex\Application();

  //Twig Path
  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  //Route and Controller

  $app->get("/", function() use ($app) {
    return $app['twig']->render('carsearch.html.twig');
});

  //Gets the user input from add a car
  $app->get("/added", function() use ($app) {
    $car_make = $_GET["car_make"];
    $car_price = $_GET["car_price"];
    $car_miles = $_GET["car_miles"];
    $car_image = $_GET["car_image"];

    $added_car = array();
    for($i = 0; $i < 10; $i++) {
      $newcar = "newcar_$i";
      $$newcar = new Car($car_make, $car_price, $car_miles, $car_image);
      $added_car = array($newcar);
      $added_car->savecar();
    }

    $added_cars = Car::getAllCar();
    return $app['twig']->render('addcar.html.twig'); 

  });

  // Setting for loop to get user inputs, test against car data, and save into new_car_array
  $app->get("/cars", function() use ($app) {
    //Gets the user input from car search
    $user_price = $_GET["user_price"];
    $user_miles = $_GET["user_miles"];


    $porsche = new Car("2014 Porsche 911", 114991, 7864, "img/porsche.jpg");
    $ford = new Car("2011 Ford F450", 55995, 14241, "/img/ford.jpg");
    $lexus = new Car("2013 Lexus RX 350", 44700, 20000, "/img/lexus.jpg");
    $mercedes = new Car("Mercedes Benz CLS550", 39900, 37979, "/img/cls550.jpg");
    $cars = array($porsche, $ford, $lexus, $mercedes);
    if ($added_cars != false) {
      array_push($cars, $added_cars);
    }

    $new_car_array = array();

    $counter = 0;
    $searchcar = array();
    $_SESSION['list_of_cars'] = array();
    foreach ($cars as $specific_car) {
      if ($specific_car->certainSpecs($user_price, $user_miles)) {
        $counter++;
        $new_car_array = new Car($specific_car->getMake(), $specific_car->getPrice(),
                    $specific_car->getMiles(), $specific_car->getPicture());
        $new_car_array->save();
            };
        };

        $searchcar = Car::getAll();

    return  $app['twig']->render('cardisplay.html.twig', array('searchcar' => $searchcar));

  });


  return $app;
?>
