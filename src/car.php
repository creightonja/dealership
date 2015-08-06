<?php
// $user_price = $_GET["user_price"];
// $user_miles = $_GET["user_miles"];
class Car
{
  private $make_model;
  private $price;
  private $miles;
  private $picture;

  //Constructor
  function __construct($make_model, $price, $miles, $picture) {
    $this->make_model = $make_model;
    $this->price = $price;
    $this->miles = $miles;
    $this->picture = $picture;
  }

  //Setters
  function setPrice($new_price) {
    $float_price = (float) $new_price;
    if ($float_price !=0) {
      $formatted_price = number_format($float_price, 2);
      $this->price = $formatted_price;
  }

  function setMake($new_make){
    $this->make = $new_make;
  }

  function setMiles($new_miles){
    $this->miles = $new_miles;
  }

  function setPicture($new_picture){
    $this->picture = $new_picture;
  }

  //Getters
  }
  function getPrice() {
    return $this->price;
  }

  function getMake() {
    return $this->make_model;
  }

  function getMiles() {
    return $this->miles;
  }

  function getPicture() {
    return $this->picture;
  }

  //If/Else Statement
  function certainSpecs($user_price, $user_miles) {

    if (($this->price <= $user_price) && ($this->miles <= $user_miles)) {
      return true;
    }
    else {
      return false;
    }
  }

  //Save Method
  function save()
  {
    array_push($_SESSION['list_of_cars'], $this);
  }

  //Getter Static Method
  static function getAll()
  {
    return $_SESSION['list_of_cars'];
  }

  //Static Method - Deletes Tasks
  static function deleteAll()
  {
    $_SESSION['list_of_cars'] = array();
  }

}
