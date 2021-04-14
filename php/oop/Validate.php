<?php

  /**
   *  This class will handle $_POST data and sanitize it.
   */
  class Validate
  {

    private $formData;
    private $booleanArray;
    private $boolean_verify;

    // Constructor
    public function __construct($POST){
      $this->formData = $POST;
    }

    public function cleanData(){
      foreach ($this->formData as $key => $value) {
        $this->formData[$key] = filter_var(trim($value), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_HIGH);
        $this->booleanArray[$key] = empty($this->formData[$key]);
      }
    }

    public function getBoolArray(){
      return $this->booleanArray;
    }

    public function getCleanedData(){
      return $this->formData;
    }

    public function getFormVar($key){
      return $this->formData[$key];
    }

    public function getValidationMessage(){

      $message = "";
      if (in_array(true, $this->booleanArray)) {
        $message = "The following fields were found empty: "."\n";
        foreach ($this->booleanArray as $key => $value) {
          if ($value) {
            $message .= "\n" . ucfirst($key);
          }
        }
        $message .= "\n\nForm Rejected";
      }

      return $message;

    }

    public function debugData(){
      echo "<h2> Cleaned Form Data </h2>";
      echo "<pre>";
      print_r($this->formData);
      echo "</pre>";
      echo "<h2> Boolean Array </h2>";
      echo "<pre>";
      print_r($this->booleanArray);
      echo "</pre>";
    }

    /*
      Extra functions to support register/login validations.
    */

    public function verify_set_checkLength($args_array){

      $errorKey = $args_array["errorKey"];
      $fieldKey = $args_array["fieldKey"];
      $minLength = $args_array["minLength"];
      $this->boolean_verify[$errorKey] = (strlen($this->formData[$fieldKey]) < $minLength);
    }

    public function verify_set_checkUnique($arr_field_error, $existingUsers){

      $fieldKey = $arr_field_error["fieldKey"];
      $errorKey = $arr_field_error["errorKey"];

      $this->boolean_verify[$errorKey] = in_array($this->formData[$fieldKey], $existingUsers);
    }

    public function verify_set_checkMatch_String($args_array){

      $errorKey = $args_array["errorKey"];
      $var1 = $args_array["match1"];
      $var2 = $args_array["match2"];

      $this->boolean_verify[$errorKey] = (strcmp($var1, $var2) !== 0);
    }

    public function verify_set_checkMatch_Password($args_array){

      $errorKey = $args_array["errorKey"];
      $input = $args_array["fieldKey"];
      $passHash = $args_array["passwordHash"];

      $this->boolean_verify[$errorKey] = !password_verify($this->formData[$input], $passHash);
    }

    // Passes TRUE to the array if the user does not exist; for login checks.
    // Opposite of verify_set_checkUnique
    public function verify_set_checkExisting($args_array, $userList_array){

      $errorKey = $args_array["errorKey"];
      $input = $args_array["fieldKey"];

      $this->boolean_verify[$errorKey] = !in_array($this->formData[$input], $userList_array);
    }

    public function verify_get_boolArray(){
      return $this->boolean_verify;
    }

    public function verify_get_validationMessage(){

      $message = "";
      if (in_array(true, $this->boolean_verify)) {
        $message = "";
        foreach ($this->boolean_verify as $key => $value) {
          if ($value) {
            $message .= "\n" . str_replace("_", " ",ucfirst($key));
          }
        }
        $message .= "\n\nForm Rejected";
      }

      return $message;

    }

  }


 ?>
