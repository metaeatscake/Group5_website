<?php

  /**
   * User object.
   */

  namespace Sociality\Models;
  class User
  {

    private $attributes = array();

    // PHP can't have multiple constructors.
    // Use as reference: https://stackoverflow.com/a/1701337
    public function __construct(array $attributes)
    {
      $this->attributes = $attributes;
    }

    public function getVarByKey($key){
      return $this->attributes[$key];
    }

    public function setVarByKey($key, $value){
      $this->attributes[$key] = $value;
    }

  }


 ?>
