<?php
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/car.php";

  session_start();  //Creating cookie for session
    if (empty($_SESSION['list_of_cars'])) {
      $_SESSION['list_of_cars'] = array();
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

  // Setting for loop to get user inputs, test against car data, and save into new_car_array
  $app->get("/cars", function() use ($app) {
    $user_price = $_GET["user_price"];
    $user_miles = $_GET["user_miles"];
    $porsche = new Car("2014 Porsche 911", 114991, 7864, "img/porsche.jpg");
    $ford = new Car("2011 Ford F450", 55995, 14241, "/img/ford.jpg");
    $lexus = new Car("2013 Lexus RX 350", 44700, 20000, "/img/lexus.jpg");
    $mercedes = new Car("Mercedes Benz CLS550", 39900, 37979, "/img/cls550.jpg");
    $cars = array($porsche, $ford, $lexus, $mercedes);

    $new_car_array = array();

    $counter = 0;
    foreach ($cars as $specific_car) {
      if ($specific_car->certainSpecs($user_price, $user_miles)) {
        $counter++;
        $new_car_array = new Car($specific_car->getPicture(), $specific_car->getMake(),
                    $specific_car->getMiles(), $specific_car->getPrice());
        $new_car_array->save();
            };
        };

        $searchcar = Car::getAll();

    return  $app['twig']->render('cardisplay.html.twig', array('searchcar' => $new_car_array));

  });

  return $app;
?>
