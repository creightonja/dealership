<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/car.php";

  session_start();  //Creating cookie for session
    $porsche = new Car("2014 Porsche 911", 114991, 7864, "img/porsche.jpg");
    $ford = new Car("2011 Ford F450", 55995, 14241, "/img/ford.jpg");
    $lexus = new Car("2013 Lexus RX 350", 44700, 20000, "/img/lexus.jpg");
    $mercedes = new Car("Mercedes Benz CLS550", 39900, 37979, "/img/cls550.jpg");
    if (empty($_SESSION['list_of_cars'])) {
      $_SESSION['list_of_cars'] = array($porsche, $ford, $lexus, $mercedes);
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
  $app->post("/added", function() use ($app) {
    $car_make = $_GET['car_make'];
    $car_price = $_GET['car_price'];
    $car_miles = $_GET['car_miles'];
    $car_image = $_GET['car_image'];

    //$cars = Car::getAll();
    $newcar = array();
    $newcar = new Car($_POST['car_make'], $_POST['car_price'],
                      $_POST['car_miles'], $_POST['car_image']);
    $newcar->save();
    //array_push($newcar, $cars);
    //$cars->save();

    return $app['twig']->render('addcar.html.twig', array('addedcar' => $newcar));

  });

  //$_POST['car_make'], $_POST['car_price'], $_POST['car_miles'], $_POST['car_image']
  //   $added_car = array();
  //   for($i = 0; $i < 10; $i++) {
  //     $newcar = "newcar_$i";
  //     $$newcar =
  //     $added_car = array($newcar);
  //     //$added_car->savecar();
  //   }
  //
  //   $added_cars = Car::getAllCar();
  //
  //   $varcheck = if ($added_car != false){
  //     return "data present";
  //   }
  //
  //   return $app['twig']->render('addcar.html.twig');
  //
  // });
  //
  // Setting for loop to get user inputs, test against car data, and save into new_car_array
  $app->get("/cars", function() use ($app) {
    //Gets the user input from car search
    $user_price = $_GET["user_price"];
    $user_miles = $_GET["user_miles"];
    $cars = Car::getAll();
    $matching_cars = array();
    foreach ($cars as $car) {
      if (($car->getPrice() < $user_price) && ($car->getMiles() < $user_miles)){
        array_push($matching_cars, $car);
      }
    }

    return  $app['twig']->render('cardisplay.html.twig', array('matching_cars' => $matching_cars));

  });


  return $app;
?>
